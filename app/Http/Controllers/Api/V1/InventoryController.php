<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Solid\Repositories\InventoryRepository;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    private $data;

    public function __construct(InventoryRepository $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        return $this->data->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
