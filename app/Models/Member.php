<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'member_since',
    ];

    protected function casts(): array
    {
        return [
            'member_since' => 'date',
        ];
    }
}
