# Send Low Stock Notification Listener
=====================================

## Overview
------------

This listener is responsible for sending a notification when low stock is detected.

## Class Definition
-------------------

### SendLowStockNotification

```php
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
```

## Events
---------

### LowStockDetected

This event is triggered when low stock is detected.

## Configuration
--------------

### Queue Configuration

This listener should be configured to run on a queue to ensure that notifications are sent asynchronously.

### Event Binding

This listener should be bound to the `LowStockDetected` event.

## Example Use Cases
--------------------

*   When the stock quantity falls below the low stock threshold, this listener will send a notification to the system administrators.
*   The notification will include the item ID, item name, warehouse ID, warehouse name, current quantity, and low stock threshold.

## API Documentation
--------------------

### handle(LowStockDetected $event)

*   **Description:** Handles the `LowStockDetected` event by sending a notification.
*   **Parameters:**
    *   `$event`: The `LowStockDetected` event.
*   **Returns:** `void`

## Troubleshooting
------------------

*   If the notification is not being sent, check the queue configuration and ensure that the listener is bound to the `LowStockDetected` event.
*   If the notification is being sent but the data is incorrect, check the event data and ensure that it is being passed correctly to the listener.