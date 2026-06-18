<?php

namespace App\Models;

use App\Models\Commodity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commodity_id',
        'target_user_id',
        'status',
        'quantity',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }
}
