<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'phone'=> $this->phone,
            // 'created_at'=>$this->created_at,
            'created_at'=>(string)$this->created_at->format('d/m/y'),
        ];
    }
}
