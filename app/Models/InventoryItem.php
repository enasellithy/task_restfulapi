<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;
    protected $table = "inventory_items";
    protected $guarded;
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
    public function transfers(){
        return $this->hasMany(StockTransfer::class);
    }
}
