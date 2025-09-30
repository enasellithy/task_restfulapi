<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendLowStockNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockDetected $event): void
    {
        $stock = $event->stock->fresh(['inventoryItem', 'warehouse']);

        Log::warning('Low stock detected', [
            'item_id' => $stock->inventory_item_id,
            'item_name' => $stock->inventoryItem->name ?? 'Unknown',
            'warehouse_id' => $stock->warehouse_id,
            'warehouse_name' => $stock->warehouse->name ?? 'Unknown',
            'current_quantity' => $stock->quantity,
            'threshold' => $stock->low_stock_threshold
        ]);
    }
}
