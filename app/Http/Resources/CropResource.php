<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CropResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id ,
            "genre"=> $this->genre ,
            "target"=> __("home.".$this->target) ,
            "quantity"=> $this->quantity ,
            "Price"=> $this->Price ,
            "phone" => $this->phone ,
            "video"=> $this->video  ? url('storage/' . $this->video) :null ,
            "city" => $this->city->name ,
            "user" => $this->user->name ,
            'img'   => $this->img  ? url('storage/' . $this->img) :null ,
            "type" => __($this->type) ,
            "created_at" => $this->created_at->diffForHumans() ,
        ];

    }
}
