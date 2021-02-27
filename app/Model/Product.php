<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'product_id',
    	'name',
		'price', 
		'discount_percentage',
		'description',
		'image'
    ];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $casts = [
        'price' => 'float'
    ];

    
}