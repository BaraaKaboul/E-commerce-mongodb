<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return view('user.index');
    }
}
