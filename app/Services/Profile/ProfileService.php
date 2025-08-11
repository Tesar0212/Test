<?php

namespace App\Services\Profile;

use App\Services\Profile\DTO\ProfileUpdateDTO;
use App\User;

class ProfileService
{
    public function updateUserProfile(User $user, ProfileUpdateDTO $dto): User
    {
        $user->fill($dto->toArray());

        if ($dto->avatar) {
            $path = $dto->avatar->store('avatars', 'public');
            $user->avatar_url = 'storage/' . $path;
        }

        $user->save();

        return $user->refresh();
    }
}


