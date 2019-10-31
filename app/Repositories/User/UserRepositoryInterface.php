<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Handle login callback with google.
     *
     * @param mixed $googleUser //
     *
     * @return void
     */
    public function handleLoginCallBack($googleUser);
}
