<?php
namespace cinema\useCases\auth;

use cinema\entities\User\User;
use cinema\forms\auth\SignupForm;
use cinema\repositories\UserRepository;

class SignupService
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function signup(SignupForm $form)
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->users->save($user);
        return $user;
    }

}