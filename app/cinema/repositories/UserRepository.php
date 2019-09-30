<?php
namespace cinema\repositories;

use cinema\entities\User\User;

class UserRepository
{


    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function findByUsernameOrEmail($value): ?User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new \DomainException('User not found.');
        }
        return $user;
    }

}