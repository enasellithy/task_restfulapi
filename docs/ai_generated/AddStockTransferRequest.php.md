# Add Stock Transfer Request
==========================

## Overview
-----------

This is a Laravel Form Request class for validating stock transfer requests.

## Usage
-----

To use this class, create a new instance of it in your controller and call the `validate()` method.

### Example
```php
use App\Http\Requests\Api\V1\StockTransfer\AddStockTransferRequest;

class StockTransferController extends Controller
{
    public function store(AddStockTransferRequest $request)
    {
        // The request is validated automatically by the FormRequest class
        // You can access the validated data using $request->validated()
        $validatedData = $request->validated();

        // Process the stock transfer
        // ...
    }
}
```

## Validation Rules
------------------

The following validation rules are defined in this class:

### from_warehouse_id

*   `required`: The warehouse ID is required.
*   `exists:warehouses,id`: The warehouse ID must exist in the `warehouses` table.
*   Custom validation: Checks if there is a stock available in the warehouse with the specified quantity.

### to_warehouse_id

*   `required`: The warehouse ID is required.
*   `exists:warehouses,id`: The warehouse ID must exist in the `warehouses` table.
*   `different:from_warehouse_id`: The warehouse ID must be different from the `from_warehouse_id`.

### inventory_item_id

*   `required`: The inventory item ID is required.
*   `exists:inventory_items,id`: The inventory item ID must exist in the `inventory_items` table.

### quantity

*   `required`: The quantity is required.
*   `integer`: The quantity must be an integer.
*   `min:1`: The quantity must be at least 1.

### notes

*   `nullable`: The notes are optional.
*   `string`: The notes must be a string.

## Custom Validation
--------------------

The `getSourceStock()` method is used to retrieve the stock available in the warehouse with the specified quantity.

## Error Handling
-----------------

The `failedValidation()` method is used to handle validation errors. It throws an `HttpResponseException` with the error message.

## Traits
---------

This class uses the `JsonTrait` trait, which provides a `whenError()` method for returning error messages in JSON format.

### whenError() Method
```php
public function whenError($error)
{
    return response()->json(['error' => $error], 422);
}
```
This method returns a JSON response with the error message and a 422 status code.