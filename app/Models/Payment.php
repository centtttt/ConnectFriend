<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
