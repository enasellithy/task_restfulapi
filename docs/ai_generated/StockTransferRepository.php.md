# Stock Transfer Repository
==========================

## Overview
------------

The Stock Transfer Repository is responsible for managing stock transfers between warehouses. It provides methods for creating, updating, and deleting stock transfers, as well as executing and reversing transfers.

## Methods
----------

### `create(array $data)`

Creates a new stock transfer.

*   **Parameters:** `$data` (array) - The data to create the stock transfer with.
*   **Returns:** The created stock transfer.

```php
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
```

### `updateTransfer(StockTransfer $transfer, array $data): StockTransfer`

Updates an existing stock transfer.

*   **Parameters:** `$transfer` (StockTransfer) - The stock transfer to update.
*   **Parameters:** `$data` (array) - The data to update the stock transfer with.
*   **Returns:** The updated stock transfer.

```php
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
```

### `deleteTransfer(StockTransfer $transfer): bool`

Deletes an existing stock transfer.

*   **Parameters:** `$transfer` (StockTransfer) - The stock transfer to delete.
*   **Returns:** A boolean indicating whether the deletion was successful.

```php
public function deleteTransfer(StockTransfer $transfer): bool
{
    return DB::transaction(function () use ($transfer) {
        if ($transfer->status === 'completed') {
            $this->reverseTransfer($transfer);
        }
        return $transfer->delete();
    });
}
```

### `executeTransfer(StockTransfer $transfer): void`

Executes a stock transfer by updating the stock quantities in the involved warehouses.

*   **Parameters:** `$transfer` (StockTransfer) - The stock transfer to execute.

```php
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
```

### `reverseTransfer(StockTransfer $transfer): void`

Reverses a stock transfer by updating the stock quantities in the involved warehouses.

*   **Parameters:** `$transfer` (StockTransfer) - The stock transfer to reverse.

```php
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
```

### `isCriticalDataChanged(StockTransfer $transfer, array $data): bool`

Checks if critical data has changed in the stock transfer.

*   **Parameters:** `$transfer` (StockTransfer) - The stock transfer to check.
*   **Parameters:** `$data` (array) - The data to check against.
*   **Returns:** A boolean indicating whether critical data has changed.

```php
private function isCriticalDataChanged(StockTransfer $transfer, array $data): bool
{
    return isset($data['from_warehouse_id']) && $transfer->from_warehouse_id != $data['from_warehouse_id'] ||
        isset($data['to_warehouse_id']) && $transfer->to_warehouse_id != $data['to_warehouse_id'] ||
        isset($data['inventory_item_id']) && $transfer->inventory_item_id != $data['inventory_item_id'] ||
        isset($data['quantity']) && $transfer->quantity != $data['quantity'];
}
```