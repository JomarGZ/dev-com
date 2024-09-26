<?php

namespace App\Models;

use App\Traits\Friendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    public const PENDING = 0;
    public const ACCEPTED = 1;
}
