<?php

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
