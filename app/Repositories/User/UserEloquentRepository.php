<?php

namespace App\Repositories\User;

use DB;
use Auth;
use App\Models\SocialAccount;
use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }

    /**
     * Handle login callback with google.
     *
     * @param mixed $googleUser
     *
     * @return void
     */
    public function handleLoginCallBack($googleUser)
    {
        DB::beginTransaction();
        try {
            $email = $googleUser->getEmail() ?? $googleUser->getNickname();
            $socialAccount = SocialAccount::firstOrNew(
                ['provider_user_id' => $googleUser->getId()],
                ['provider' => 'google']
            );

            $user = $this->model->whereEmail($email)->first();

            if (!$user) {
                $user = $this->model::create([
                    'email' => $email,
                    'name' => $googleUser->getName(),
                    'password' => bcrypt($googleUser->getName()),
                ]);

                $socialAccount->user()->associate($user);
                $socialAccount->save();
            }

            Auth::login($user, true);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error($e);

            throw $e;
        }
    }
}
