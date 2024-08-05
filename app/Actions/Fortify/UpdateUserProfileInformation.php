<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'department' => ['string', 'max:255'],
            'phone' => ['string', 'max:255'],
            'location' => ['string', 'max:255'],
            'is_admin' => ['sometimes', 'required', 'boolean'],
        ])->validateWithBag('updateProfileInformation');

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'department' => $input['department'],
            'phone' => $input['phone'],
            'location' => $input['location'],
            'is_admin' => $input['is_admin'],
        ])->save();
    }
}
