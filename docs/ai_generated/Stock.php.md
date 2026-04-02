# Stock Model Documentation
=====================================

## Overview
------------

The `Stock` model represents a stock item in the application. It is a Eloquent model that interacts with the `stocks` table in the database.

## Properties
------------

### Table Name

*   `$table`: The name of the database table associated with this model. Defaults to `stocks`.

### Guarded Attributes

*   `$guarded`: An array of attributes that are not mass-assignable. Defaults to an empty array.

## Relationships
--------------

### Warehouse

*   `warehouse()`: A belongs-to relationship with the `Warehouse` model.

### Inventory Item

*   `inventoryItem()`: A belongs-to relationship with the `InventoryItem` model.

## Usage
-----

### Example Usage

```php
$stock = Stock::find(1);
$warehouse = $stock->warehouse;
$inventoryItem = $stock->inventoryItem;
```

### Mass Assignment

```php
$stock = new Stock();
$stock->fill([
    'name' => 'Example Stock',
    'quantity' => 10,
    'warehouse_id' => 1,
    'inventory_item_id' => 1,
]);
$stock->save();
```

### Validation

```php
$validator = Validator::make($request->all(), [
    'name' => 'required',
    'quantity' => 'required|integer',
]);
if ($validator->fails()) {
    // Handle validation errors
}
```

## API Documentation
-------------------

### GET /stocks/{id}

*   Retrieves a stock item by ID.

### POST /stocks

*   Creates a new stock item.

### PUT /stocks/{id}

*   Updates a stock item.

### DELETE /stocks/{id}

*   Deletes a stock item.

## Changelog
------------

*   1.0.0: Initial release.
*   1.1.0: Added `warehouse` and `inventoryItem` relationships.
*   1.2.0: Added mass assignment and validation examples.