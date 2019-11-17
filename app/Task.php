<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable=[
        'name',
        'description',
        'status'        
    ];

    const CREATED = 0;
    const DOING = 1;
    const CANCEL = 2;
    const DONE = 3;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
