<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;

use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;

/**
 * Class Branch
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Branch
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $isDefault = FALSE;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Gets the Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the Is Default
     *
     * @return bool
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Sets the Is Default
     *
     * @param bool $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
    }

    /**
     * Gets the Repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the Repository
     *
     * @param Repository $repository
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
    }


}