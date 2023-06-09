<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $appends = ['image_url'];
    protected $hidden = [];

    public function getImageUrlAttribute(){

        $image_url = '';
        if($this->image){
            $image_url = asset('storage/'.$this->image);
        }
        return $image_url;
    }
}
