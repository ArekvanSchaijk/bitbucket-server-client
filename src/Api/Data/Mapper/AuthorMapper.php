<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Author;

/**
 * Class AuthorMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class AuthorMapper extends Adapter
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
     * @return Author
     * @static
     */
    static public function map($data)
    {
        $author = new Author();
        if (isset($data->user)) {
            $author->setUser(UserMapper::map($data->user));
        }
        $author->setRole((string)$data->role);
        $author->setApproved((bool)$data->approved);
        $author->setStatus((string)$data->status);
        return $author;
    }

}