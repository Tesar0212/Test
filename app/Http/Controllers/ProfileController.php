<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Profile\DTO\ProfileUpdateDTO;
use App\Services\Profile\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile');
    }

    public function data(): JsonResponse
    {
        $user = Auth::user();
        $avatarUrl = $user->avatar_url ? asset($user->avatar_url) : null;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'job' => $user->job,
            'company' => $user->company,
            'phone' => $user->phone,
            'mobile' => $user->mobile,
            'country' => $user->country,
            'avatar_url' => $avatarUrl,
        ]);
    }

    public function update(ProfileUpdateRequest $request, ProfileService $service): JsonResponse
    {
        $user = Auth::user();

        $dto = ProfileUpdateDTO::fromArray($request->validated(), $request->file('avatar'));
        $service->updateUserProfile($user, $dto);

        return response()->json(['status' => 'ok']);
    }
}


