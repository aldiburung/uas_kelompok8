<?php

namespace App\Models;

use App\Models\BarterRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'village',
        'unit',
        'stock',
        'estimated_value',
        'description',
    ];

    protected $casts = [
        'stock' => 'integer',
        'estimated_value' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barterRequests()
    {
        return $this->hasMany(BarterRequest::class);
    }
}
