# InventoryItem Model
======================

## Overview
-----------

The `InventoryItem` model represents a single item in the inventory. It is a subclass of the `Model` class provided by Laravel's Eloquent ORM.

## Properties
------------

### Table Name

*   `$table`: The name of the database table associated with this model. Defaults to `inventory_items`.

### Guarded Attributes

*   `$guarded`: An array of attributes that are not mass-assignable. If not specified, all attributes are mass-assignable.

## Relationships
--------------

### Stocks

*   `stocks()`: Returns a collection of `Stock` models that belong to this `InventoryItem`.

### Transfers

*   `transfers()`: Returns a collection of `StockTransfer` models that belong to this `InventoryItem`.

## Usage
-----

### Retrieving an Inventory Item

```php
$inventoryItem = InventoryItem::find(1);
```

### Retrieving Stocks for an Inventory Item

```php
$stocks = $inventoryItem->stocks()->get();
```

### Retrieving Transfers for an Inventory Item

```php
$transfers = $inventoryItem->transfers()->get();
```

## Example Use Cases
--------------------

*   Retrieving a list of all inventory items with their associated stocks and transfers:
    ```php
$inventoryItems = InventoryItem::with('stocks', 'transfers')->get();
```

## API Documentation
--------------------

### GET /inventory-items/{id}

*   Retrieves a single inventory item by ID.
*   Returns a `InventoryItem` model instance.

### GET /inventory-items/{id}/stocks

*   Retrieves a collection of stocks associated with the specified inventory item.
*   Returns a collection of `Stock` model instances.

### GET /inventory-items/{id}/transfers

*   Retrieves a collection of transfers associated with the specified inventory item.
*   Returns a collection of `StockTransfer` model instances.