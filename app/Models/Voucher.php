<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "discount_type",
        "discount_value",
        "discount_max",
        "quantity",
        "user_count",
        "day_start",
        "day_end",
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vouchers_user');
    }
}
