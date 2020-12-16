<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'end_date', 'start_date'];

    public function operator(){
        return $this->belongsTo('App\Models\Operator');
    }
}
