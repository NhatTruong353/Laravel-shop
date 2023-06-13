<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
    use HasFactory;

    protected $table = 'usermeta';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function users() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
