# Inventory Repository
======================

## Overview
------------

The `InventoryRepository` class is responsible for managing inventory data. It provides methods for retrieving all inventory items, warehouses, and a specific warehouse.

## Methods
----------

### getAll()

#### Description
Retrieve all inventory items with optional filtering and pagination.

#### Parameters
* `warehouse_id`: Filter by warehouse ID.
* `name`: Filter by inventory item name.
* `sku`: Filter by inventory item SKU.
* `min_price`: Filter by minimum price.
* `max_price`: Filter by maximum price.
* `per_page`: Number of items per page (default: 10).

#### Returns
A paginated collection of inventory items.

### getAllWarehouses()

#### Description
Retrieve all warehouses with pagination.

#### Returns
A paginated collection of warehouses.

### showWarehouse($id)

#### Description
Retrieve a specific warehouse by ID.

#### Parameters
* `$id`: The ID of the warehouse to retrieve.

#### Returns
The warehouse data if found, otherwise an error response.

## Traits
--------

### JsonTrait

The `JsonTrait` is used to handle JSON responses.

## Cache
--------

The `Cache` facade is used to cache the inventory data for 1 minute.

## Example Usage
---------------

```php
$inventory = app(InventoryRepository::class)->getAll();
$warehouses = app(InventoryRepository::class)->getAllWarehouses();
$warehouse = app(InventoryRepository::class)->showWarehouse(1);
```

## API Endpoints
----------------

### GET /inventory

* Retrieve all inventory items with optional filtering and pagination.

### GET /warehouses

* Retrieve all warehouses with pagination.

### GET /warehouses/{id}

* Retrieve a specific warehouse by ID.