<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Entity;

/**
 * Class Author
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Author
{

    const

        ROLE_AUTHOR = 'AUTHOR',
        ROLE_REVIEWER = 'REVIEWER';

    const

        STATUS_UNAPPROVED = 'UNAPPROVED',
        STATUS_APPROVED = 'APPROVED';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var bool
     */
    protected $approved;

    /**
     * @var string
     */
    protected $status;

    /**
     * Gets the User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the User
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Gets the Role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets the Role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Gets the Approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * Sets the Approved
     *
     * @param bool $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * Gets the Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the Status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}