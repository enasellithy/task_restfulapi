# Inventory Controller
=====================

## Overview
-----------

This is the `InventoryController` class, responsible for handling API requests related to inventory management.

## Dependencies
------------

* `App\Http\Controllers\Controller`
* `App\Solid\Repositories\InventoryRepository`
* `Illuminate\Http\Request`

## Properties
------------

### `$data`

* Type: `InventoryRepository`
* Description: An instance of the `InventoryRepository` class, used to interact with the inventory data.

## Methods
---------

### `__construct(InventoryRepository $data)`

* Description: Initializes the controller with an instance of the `InventoryRepository` class.
* Parameters:
	+ `$data`: An instance of the `InventoryRepository` class.

### `index()`

* Description: Returns a collection of all inventory items.
* Returns: A collection of inventory items.

### `store(Request $request)`

* Description: Creates a new inventory item.
* Parameters:
	+ `$request`: An instance of the `Request` class, containing the data for the new inventory item.
* Returns: The newly created inventory item.

### `show(string $id)`

* Description: Returns a single inventory item by its ID.
* Parameters:
	+ `$id`: The ID of the inventory item to retrieve.
* Returns: The inventory item with the specified ID.

### `update(Request $request, string $id)`

* Description: Updates an existing inventory item.
* Parameters:
	+ `$request`: An instance of the `Request` class, containing the updated data for the inventory item.
	+ `$id`: The ID of the inventory item to update.
* Returns: The updated inventory item.

### `destroy(string $id)`

* Description: Deletes an inventory item by its ID.
* Parameters:
	+ `$id`: The ID of the inventory item to delete.
* Returns: A success message indicating that the inventory item was deleted.

## Example Use Cases
--------------------

### Retrieving all inventory items

```php
$inventory = new InventoryController();
$inventoryItems = $inventory->index();
```

### Creating a new inventory item

```php
$inventory = new InventoryController();
$inventoryItem = $inventory->store($request);
```

### Retrieving a single inventory item

```php
$inventory = new InventoryController();
$inventoryItem = $inventory->show($id);
```

### Updating an existing inventory item

```php
$inventory = new InventoryController();
$inventoryItem = $inventory->update($request, $id);
```

### Deleting an inventory item

```php
$inventory = new InventoryController();
$inventory->destroy($id);
```