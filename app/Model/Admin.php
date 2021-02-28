<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;

class Admin extends Authenticatable
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
    protected $fillable = ['admin_id','name', 'email', 'status', 'password'];
    
    protected $hidden = ['password', 'remember_token'];
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
