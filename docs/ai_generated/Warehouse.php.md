# Warehouse Model
================

## Overview
--------

The `Warehouse` model represents a physical warehouse in the system. It is responsible for managing the inventory and stock levels within the warehouse.

## Properties
------------

### Table Name

*   `$table`: The name of the database table associated with this model. Defaults to `warehouses`.

### Guarded Attributes

*   `$guarded`: An array of attributes that are not mass-assignable. Defaults to an empty array.

## Relationships
--------------

### Stocks

*   `stocks()`: Returns a collection of `Stock` models that belong to this warehouse.

### Outgoing Transfers

*   `outgoingTransfers()`: Returns a collection of `StockTransfer` models that originate from this warehouse.

### Incoming Transfers

*   `incomingTransfers()`: Returns a collection of `StockTransfer` models that are destined for this warehouse.

## Usage
-----

### Retrieving a Warehouse

```php
$warehouse = Warehouse::find(1);
```

### Retrieving Stocks for a Warehouse

```php
$stocks = $warehouse->stocks;
```

### Retrieving Outgoing Transfers for a Warehouse

```php
$outgoingTransfers = $warehouse->outgoingTransfers;
```

### Retrieving Incoming Transfers for a Warehouse

```php
$incomingTransfers = $warehouse->incomingTransfers;
```

## API Documentation
-------------------

### GET /warehouses/{id}

*   Retrieves a warehouse by its ID.

### GET /warehouses/{id}/stocks

*   Retrieves the stocks for a warehouse.

### GET /warehouses/{id}/outgoing-transfers

*   Retrieves the outgoing transfers for a warehouse.

### GET /warehouses/{id}/incoming-transfers

*   Retrieves the incoming transfers for a warehouse.