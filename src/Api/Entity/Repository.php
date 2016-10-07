<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity;

/**
 * Class Repository
 * @package ArekvanSchaijk\BitbucketServerClient\Api\Entity
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Repository
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $isPublic;

    /**
     * @var bool
     */
    protected $isForkable;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $scmId;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $statusMessage;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $cloneUrl;

    /**
     * @var string
     */
    protected $sshCloneUrl;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    public function getIsForkable()
    {
        return $this->isForkable;
    }

    public function setIsForkable($isForkable)
    {
        $this->isForkable = $isForkable;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getScmId()
    {
        return $this->scmId;
    }

    public function setScmId($scmId)
    {
        $this->scmId = $scmId;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getCloneUrl()
    {
        return $this->cloneUrl;
    }

    public function setCloneUrl($cloneUrl)
    {
        $this->cloneUrl = $cloneUrl;
    }

    public function getSshCloneUrl()
    {
        return $this->sshCloneUrl;
    }

    public function setSshCloneUrl($sshCloneUrl)
    {
        $this->sshCloneUrl = $sshCloneUrl;
    }

}