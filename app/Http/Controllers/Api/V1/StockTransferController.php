<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StockTransfer\AddStockTransferRequest;
use App\Solid\Repositories\StockTransferRepository;
use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    private $data;

    public function __construct(StockTransferRepository $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddStockTransferRequest $r)
    {
        return $this->data->create($r->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
