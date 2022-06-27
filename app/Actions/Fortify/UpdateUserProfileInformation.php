<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public $tanggal_lahir;
    protected $listeners = ['setWaktu'];
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'tempat_lahir' => $input['tempat_lahir'],
                'tanggal_lahir' => $this->tanggal_lahir,//;($input['tanggal_lahir']) ? date('Y-m-d', strtotime($input['tanggal_lahir'])) : NULL,
                'alamat_rumah' => $input['alamat_rumah'],
                //'regency_id' => $input['regency_id'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'tempat_lahir' => $input['tempat_lahir'],
            'tanggal_lahir' => $this->tanggal_lahir, // $input['tanggal_lahir'],
            'alamat_rumah' => $input['alamat_rumah'],
            //'regency_id' => $input['regency_id'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
    public function setWaktu($value){
        dd($value);
        $this->tanggal_lahir = $value;
    }
}
