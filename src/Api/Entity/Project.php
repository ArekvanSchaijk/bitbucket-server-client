<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity;

use ArekvanSchaijk\BitbucketServerClient\Api;
use ArekvanSchaijk\BitbucketServerClient\Api\Exception;

/**
 * Class Project
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Project
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $isPublic;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var null|\SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository>
     */
    protected $repositories;

    /**
     * Gets the Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Id
     *
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the Key
     *
     * @param string $key
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Gets the Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the Is Public
     *
     * @return bool
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Sets the Is Public
     *
     * @param bool $isPublic
     * @return void
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Gets the Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the Type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the Link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Gets the Repositories
     *
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository>
     * @throws Exception\NoProjectKeyGivenException
     */
    public function getRepositories()
    {
        if (is_null($this->repositories)) {
            $api = new Api();
            if (empty($this->getKey())) {
                throw new Exception\NoProjectKeyGivenException('Could not retrieve repositories since there was no' .
                    ' project key given.');
            }
            $this->repositories = $api->getRepositoriesByProject($this->getKey());
        }
        return $this->repositories;
    }

}