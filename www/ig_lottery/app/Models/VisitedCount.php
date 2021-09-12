<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitedCount extends Model
{
    use HasFactory;
    protected $fillable=['visitor'];
}
