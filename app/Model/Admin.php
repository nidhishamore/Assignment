<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
	/**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'admin_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillale = ['admin_id','name', 'email', 'status'];
    
    protected $hidden = ['password'];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected function setPasswordAttribute($value)
    {
    	$this->attributes['password'] = Hash::make($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
