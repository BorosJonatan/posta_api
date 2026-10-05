<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'zip_code',
        'county_id',
        'population'
    ];

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}