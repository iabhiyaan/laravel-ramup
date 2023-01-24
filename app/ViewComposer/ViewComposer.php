<?php

namespace App\ViewComposer;

use App\Repositories\User\UserRepository;
use Illuminate\View\View;

class ViewComposer
{

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with([]);
    }
}
