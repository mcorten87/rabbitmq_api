<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\rabbitmq_api\jobs;


use mcorten87\rabbitmq_api\objects\User;

class JobUserList extends JobBase
{
    /**
     * @var User
     */
    private $user;

    public function hasUser() : bool
    {
        return $this->user instanceof User;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


}
