<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $guarded = [];

    public function transactions() {
        return $this->belongsToMany(Medicine::class, "transaction_medicine")
            ->withPivot('stock', 'price');
    }
}
