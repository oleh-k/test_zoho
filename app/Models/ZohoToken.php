<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'refresh_token',
        'access_token'
    ];

    protected $visible = [
        'refresh_token',
        'access_token',
        'updated_at'
    ];

}
