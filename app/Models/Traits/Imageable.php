<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait Imageable
{
    /**
     * Set model image
     *
     * @param $attribute
     * @param $folder
     * @param $value
     */
    protected function setImage($attribute, $folder, $value)
    {
        if ($value == null && $this->{$attribute}) {
            Storage::delete($this->{$attribute});
            $this->attributes[$attribute] = null;
        } else if ($value == null) {
            $this->attributes[$attribute] = null;
        } else {
            $ext = $value->getClientOriginalExtension();
            $filename = md5(time() . uniqid());

            if (!Storage::exists($folder)) {
                File::makeDirectory(storage_path('app/') . $folder);
            }

            Storage::putFileAs($folder, $value, $filename . '.' . $ext);

            if ($this->{$attribute}) {
                Storage::delete($this->{$attribute});
            }

            $this->attributes[$attribute] = $folder . '/' . $filename . '.' . $ext;
        }
    }
}