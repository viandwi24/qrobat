<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function medicines() {
        return $this->belongsToMany(Medicine::class, "transaction_medicine")
            ->withPivot('stock', 'price');
    }
}
