<?php

namespace App\Models;

use App\Models\Termin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'category',
        'amount',
        'transaction_date',
        'termin_id',
        'note',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function termin()
    {
        return $this->belongsTo(Termin::class);
    }

    public static function categories(): array
    {
        return [
            'Material',
            'Upah',
            'Operasional',
        ];
    }
}
