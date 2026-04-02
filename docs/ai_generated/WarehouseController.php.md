# Warehouse Controller API Documentation
=====================================

## Overview
------------

The Warehouse Controller is responsible for managing warehouse-related operations in the API. It provides endpoints for retrieving and displaying warehouse information.

## Endpoints
------------

### GET /warehouses

#### Description
Retrieve a list of all warehouses.

#### Response
```json
[
    {
        "id": 1,
        "name": "Warehouse 1",
        "address": "123 Main St"
    },
    {
        "id": 2,
        "name": "Warehouse 2",
        "address": "456 Elm St"
    }
]
```

### GET /warehouses/{id}

#### Description
Retrieve a specific warehouse by ID.

#### Parameters
* `id`: The ID of the warehouse to retrieve.

#### Response
```json
{
    "id": 1,
    "name": "Warehouse 1",
    "address": "123 Main St"
}
```

### GET /warehouses/{id}/inventory

#### Description
Retrieve the inventory for a specific warehouse.

#### Parameters
* `id`: The ID of the warehouse to retrieve inventory for.
* `request`: The request object containing query parameters.

#### Response
```json
{
    "id": 1,
    "name": "Warehouse 1",
    "address": "123 Main St",
    "inventory": [
        {
            "product_id": 1,
            "quantity": 10
        },
        {
            "product_id": 2,
            "quantity": 20
        }
    ]
}
```

## Dependencies
------------

* `App\Solid\Repositories\InventoryRepository`: Provides repository functionality for inventory data.

## Implementation
------------

### WarehouseController.php
```php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Solid\Repositories\InventoryRepository;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private $data;

    public function __construct(InventoryRepository $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        return $this->data->getAllWarehouses();
    }

    public function show($id)
    {
        return $this->data->showWarehouse($id);
    }

    public function inventory($id)
    {
        return $this->data->showWarehouse($id, request());
    }
}
```

## API Request/Response Examples
--------------------------------

### GET /warehouses

```bash
curl -X GET \
  http://example.com/api/v1/warehouses \
  -H 'Content-Type: application/json'
```

### GET /warehouses/{id}

```bash
curl -X GET \
  http://example.com/api/v1/warehouses/1 \
  -H 'Content-Type: application/json'
```

### GET /warehouses/{id}/inventory

```bash
curl -X GET \
  http://example.com/api/v1/warehouses/1/inventory \
  -H 'Content-Type: application/json'
```