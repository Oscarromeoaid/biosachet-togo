<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'message',
        'traite_le',
    ];

    protected function casts(): array
    {
        return [
            'traite_le' => 'datetime',
        ];
    }
}
