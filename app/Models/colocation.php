<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class colocation extends Model
{
    protected $fillable = [
        'title',
        'status',
        'owner_id',


        ];

public function members (){

return $this->belongsToMany(User::class, 'memberships')
                ->withPivot('role', 'left_at')
                ->withTimestamps();
    }

        public function owner()
    {
            return  $this->belongTo(Colocation::class,'memberships')
        ->withPivot('role','left_at')
        ->withTimestamps();
    }



}



