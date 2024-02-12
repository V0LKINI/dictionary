<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function save(array $data, ?UploadedFile $image): Model | Exception
    {
        $user = User::findOrFail($data['id']);

        if (is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->image = $image;
        $user->fill($data);
        $user->save();

        return $user;
    }
}