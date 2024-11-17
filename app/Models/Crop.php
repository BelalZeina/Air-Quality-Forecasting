<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;
    protected $fillable = [
        "genre",
        "target",
        "quantity",
        "Price",
        "phone",
        "img",
        "video",
        "city_id",
        "user_id",
        "type",
    ];

    public function city(){
        return $this->belongsTo(City::class , 'city_id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
