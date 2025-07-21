<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocaleRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService) {}

    /**
     * Save user data
     *
     * @param ProfileRequest $request
     */
    public function save(ProfileRequest $request)
    {
        try {
            $data = $request->safe()->except('password_confirm');
            $image = $request->file('image');

            $user = $this->profileService->save(data: $data, image: $image);

            $response = [
                'user' => UserResource::make($user),
            ];

            return $this->success($response);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Change user's locale
     *
     * @param LocaleRequest $request
     */
    public function changeLocale(LocaleRequest $request)
    {
        try {
            $user = $this->profileService->changeLocale(locale: $request->input('locale'));

            $response = [
                'user' => UserResource::make($user),
            ];

            return $this->success($response);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

}
