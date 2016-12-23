<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity;

use ArekvanSchaijk\BitbucketServerClient\Api;

/**
 * Class Repository
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

    /**
     * @var null|\SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Branch>
     */
    protected $branches;

    /**
     * @var array
     */
    protected $commits = [];

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
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Gets the Is Forkable
     *
     * @return bool
     */
    public function getIsForkable()
    {
        return $this->isForkable;
    }

    /**
     * Sets the Is Forkable
     *
     * @param bool $isForkable
     */
    public function setIsForkable($isForkable)
    {
        $this->isForkable = $isForkable;
    }

    /**
     * Gets the Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the Slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Gets the Scm Id
     *
     * @return string
     */
    public function getScmId()
    {
        return $this->scmId;
    }

    /**
     * Sets the Scm Id
     *
     * @param string $scmId
     */
    public function setScmId($scmId)
    {
        $this->scmId = $scmId;
    }

    /**
     * Gets the State
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets the State
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Gets tje Status Message
     *
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * Sets the Status Message
     *
     * @param string $statusMessage
     */
    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }

    /**
     * Gets the Project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Sets the Project
     *
     * @param Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
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
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Gets the Clone Url
     *
     * @return string
     */
    public function getCloneUrl()
    {
        return $this->cloneUrl;
    }

    /**
     * Sets the Clone Url
     *
     * @param string $cloneUrl
     */
    public function setCloneUrl($cloneUrl)
    {
        $this->cloneUrl = $cloneUrl;
    }

    /**
     * Gets the Ssh Clone Url
     *
     * @return string
     */
    public function getSshCloneUrl()
    {
        return $this->sshCloneUrl;
    }

    /**
     * Sets the Ssh Clone Url
     *
     * @param string $sshCloneUrl
     */
    public function setSshCloneUrl($sshCloneUrl)
    {
        $this->sshCloneUrl = $sshCloneUrl;
    }

    /**
     * Gets the Branches
     *
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Branch>
     */
    public function getBranches()
    {
        if (is_null($this->branches)) {
            $api = new Api();
            $this->branches = $api->getRepositoryBranches($this);
        }
        return $this->branches;
    }

    /**
     * Gets the Commits
     *
     * @param string $branchName
     * @return array
     */
    public function getCommits($branchName = 'master')
    {
        if (!isset($this->commits[$branchName])) {
            $api = new Api();
            $this->commits[$branchName] = $api->getCommits($this, $branchName);
        }
        return $this->commits[$branchName];
    }

}