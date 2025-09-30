<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = "stocks";
    protected $guarded;
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
    public function inventoryItem(){
        return $this->belongsTo(InventoryItem::class);
    }
}
