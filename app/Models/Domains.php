<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    use HasFactory;

    public function records(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Records::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($domain) {
            $domain->records()->delete();
        });
    }
}
