<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cainfo extends Model
{
    use HasFactory;

    protected $fillable = ['cacode', 'email', 'phone', 'plan'];

    protected $table = 'cainfos'; // Optional if your table name follows Laravel's conventions
}
