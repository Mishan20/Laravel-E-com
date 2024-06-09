<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 *
 * @property $name
 * @property $phone
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Bank extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'phone'];


}
