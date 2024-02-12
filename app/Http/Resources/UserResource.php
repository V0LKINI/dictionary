<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminApi\UserCompanyResource;
use App\Http\Resources\AdminApi\UserRoleResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'image' =>  $this->image ? url('/storage/' . $this->image) : null,
            'created_at' => Carbon::parse($this->created_at)->format('d F Y')
        ];
    }
}
