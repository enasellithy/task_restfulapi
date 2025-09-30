<?php


namespace App\Solid\Repositories;


use App\Models\Stock;
use App\Models\StockTransfer;
use App\Solid\Traits\JsonTrait;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\exactly;

class StockTransferRepository
{
    use JsonTrait;

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $transfer = StockTransfer::create($data);
            // if status is completed
            if ($transfer->status === 'completed') {
                $this->executeTransfer($transfer);
            }
            return $this->whenDone($transfer,'Create Successfully');
        });
    }

    public function updateTransfer(StockTransfer $transfer, array $data): StockTransfer
    {
        return DB::transaction(function () use ($transfer, $data) {
            $originalData = $transfer->getOriginal();
            if ($transfer->status === 'completed' && $this->isCriticalDataChanged($transfer, $data)) {
                $this->reverseTransfer($transfer);
            }
            $transfer->update($data);
            if ($transfer->status === 'completed') {
                $this->executeTransfer($transfer);
            }
            return $transfer->fresh();
        });
    }

    public function deleteTransfer(StockTransfer $transfer): bool
    {
        return DB::transaction(function () use ($transfer) {
            if ($transfer->status === 'completed') {
                $this->reverseTransfer($transfer);
            }
            return $transfer->delete();
        });
    }

    public function executeTransfer(StockTransfer $transfer): void
    {
        DB::transaction(function () use ($transfer) {
            Stock::where('warehouse_id', $transfer->from_warehouse_id)
                ->where('inventory_item_id', $transfer->inventory_item_id)
                ->decrement('quantity', $transfer->quantity);
            // add to warehouse
            Stock::firstOrCreate(
                [
                    'warehouse_id' => $transfer->to_warehouse_id,
                    'inventory_item_id' => $transfer->inventory_item_id
                ],
                ['quantity' => 0]
            )->increment('quantity', $transfer->quantity);
        });
    }

    public function reverseTransfer(StockTransfer $transfer): void
    {
        DB::transaction(function () use ($transfer) {
            // return to warehouse
            Stock::where('warehouse_id', $transfer->from_warehouse_id)
                ->where('inventory_item_id', $transfer->inventory_item_id)
                ->increment('quantity', $transfer->quantity);
            // discount from wrong warhouse
            Stock::where('warehouse_id', $transfer->to_warehouse_id)
                ->where('inventory_item_id', $transfer->inventory_item_id)
                ->decrement('quantity', $transfer->quantity);
        });
    }

    private function isCriticalDataChanged(StockTransfer $transfer, array $data): bool
    {
        return isset($data['from_warehouse_id']) && $transfer->from_warehouse_id != $data['from_warehouse_id'] ||
            isset($data['to_warehouse_id']) && $transfer->to_warehouse_id != $data['to_warehouse_id'] ||
            isset($data['inventory_item_id']) && $transfer->inventory_item_id != $data['inventory_item_id'] ||
            isset($data['quantity']) && $transfer->quantity != $data['quantity'];
    }
}
