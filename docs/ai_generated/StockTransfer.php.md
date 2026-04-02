# Stock Transfer Model
======================

## Overview
-----------

The `StockTransfer` model represents a stock transfer between two warehouses. It is used to manage the transfer of inventory items from one warehouse to another.

## Properties
------------

### Table Name

*   `$table`: The name of the database table associated with this model. Defaults to `stock_transfers`.

### Fillable Attributes

*   `$fillable`: An array of attributes that can be mass-assigned. The following attributes are fillable:
    *   `from_warehouse_id`
    *   `to_warehouse_id`
    *   `inventory_item_id`
    *   `quantity`
    *   `status`
    *   `notes`
    *   `transferred_at`

### Relationships

*   `fromWarehouse`: A belongs-to relationship with the `Warehouse` model, representing the warehouse from which the inventory item is being transferred.
*   `toWarehouse`: A belongs-to relationship with the `Warehouse` model, representing the warehouse to which the inventory item is being transferred.
*   `inventoryItem`: A belongs-to relationship with the `InventoryItem` model, representing the inventory item being transferred.

## Methods
---------

### Boot Method

*   `boot`: A static method that is called when the model is bootstrapped. It sets the `status` attribute to "completed" when a new stock transfer is created.

## Example Usage
---------------

```php
$stockTransfer = new StockTransfer();
$stockTransfer->from_warehouse_id = 1;
$stockTransfer->to_warehouse_id = 2;
$stockTransfer->inventory_item_id = 3;
$stockTransfer->quantity = 10;
$stockTransfer->save();
```

### Retrieving a Stock Transfer

```php
$stockTransfer = StockTransfer::find(1);
$fromWarehouse = $stockTransfer->fromWarehouse;
$toWarehouse = $stockTransfer->toWarehouse;
$inventoryItem = $stockTransfer->inventoryItem;
```