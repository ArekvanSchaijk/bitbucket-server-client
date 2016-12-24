<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\User;

/**
 * Class UserMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class UserMapper extends Adapter
{

    /**
     * Process
     *
     * @return void
     */
    protected function process()
    {
        $data = $this->json();
        if (($values = $data->values)) {
            foreach ($values as $data) {
                $this->attach(
                    self::map($data)
                );
            }
        }
    }

    /**
     * Map
     *
     * @param mixed $data
     * @return User
     * @static
     */
    static public function map($data)
    {
        $user = new User();
        $user->setId((int)$data->id);
        $user->setFullName((string)$data->displayName);
        $user->setName((string)$data->name);
        $user->setEmail((string)$data->emailAddress);
        $user->setActive((bool)$data->active);
        $user->setSlug((string)$data->slug);
        $user->setType((string)$data->type);
        return $user;
    }

}