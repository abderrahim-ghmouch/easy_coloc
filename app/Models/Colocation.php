<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'DESACTIVE');
    }

    public function owner(){
        return $this->hasOne(ColocationMember::class)->where('role', 'Owner');
    }

    public function members(): HasMany
    {
        return $this->hasMany(ColocationMember::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(ColocationMember::class)->whereNull('left_at');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'colocation_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
