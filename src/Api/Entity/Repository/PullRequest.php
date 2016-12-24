<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;

use ArekvanSchaijk\BitbucketServerClient\Api;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Author;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;

/**
 * Class PullRequest
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class PullRequest
{

    const

        STATE_OPEN = 'OPEN',
        STATE_MERGED = 'MERGED',
        STATE_DECLINED = 'DECLINED';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var bool
     */
    protected $open;

    /**
     * @var bool
     */
    protected $closed;

    /**
     * @var int
     */
    protected $dateCreated;

    /**
     * @var int
     */
    protected $dateUpdated;

    /**
     * @var Branch
     */
    protected $fromBranch;

    /**
     * @var Branch
     */
    protected $toBranch;

    /**
     * @var bool
     */
    protected $locked;

    /**
     * @var Author
     */
    protected $author;

    /**
     * @var Author[]
     */
    protected $reviewers;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var string
     */
    protected $link;

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
     * Gets the Version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the Version
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Gets the Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the Title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Gets the Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the Description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * Gets the Open
     *
     * @return boolean
     */
    public function isOpen()
    {
        return $this->open;
    }

    /**
     * Sets the Open
     *
     * @param boolean $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
    }

    /**
     * Gets the Closed
     *
     * @return boolean
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * Sets the Closed
     *
     * @param boolean $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * Gets the DateCreated
     *
     * @return int
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Sets the DateCreated
     *
     * @param int $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Gets the DateUpdated
     *
     * @return int
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Sets the DateUpdated
     *
     * @param int $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * Gets the FromBranch
     *
     * @return Branch
     */
    public function getFromBranch()
    {
        return $this->fromBranch;
    }

    /**
     * Sets the FromBranch
     *
     * @param Branch $fromBranch
     */
    public function setFromBranch(Branch $fromBranch)
    {
        $this->fromBranch = $fromBranch;
    }

    /**
     * Gets the ToBranch
     *
     * @return Branch
     */
    public function getToBranch()
    {
        return $this->toBranch;
    }

    /**
     * Sets the ToBranch
     *
     * @param Branch $toBranch
     */
    public function setToBranch(Branch $toBranch)
    {
        $this->toBranch = $toBranch;
    }

    /**
     * Gets the Locked
     *
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * Sets the Locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Gets the Author
     *
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the Author
     *
     * @param Author $author
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * Gets the Reviewers
     *
     * @return Author[]
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    /**
     * Sets the Reviewers
     *
     * @param Author[] $reviewers
     */
    public function setReviewers($reviewers)
    {
        $this->reviews = $reviewers;
    }

    /**
     * Gets the Properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Sets the Properties
     *
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
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
     * Gets the Repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->fromBranch->getRepository();
    }

    /**
     * Merges the pull request
     *
     * @return void
     */
    public function merge()
    {
        $api = new Api();
        $api->mergePullRequest($this->getRepository(), $this);
    }

    /**
     * Declines the pull request
     *
     * @return void
     */
    public function decline()
    {
        $api = new Api();
        $api->declinePullRequest($this->getRepository(), $this);
    }

    /**
     * Reopens the pull request
     *
     * @return void
     */
    public function reopen()
    {
        $api = new Api();
        $api->reopenPullRequest($this->getRepository(), $this);
    }

}