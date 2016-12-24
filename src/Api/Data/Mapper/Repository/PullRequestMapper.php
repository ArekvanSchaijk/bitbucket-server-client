<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\AuthorMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\PullRequest;

/**
 * Class PullRequestMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class PullRequestMapper extends Adapter
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
     * @return PullRequest
     * @static
     */
    static public function map($data)
    {
        $pullRequest = new PullRequest();
        $pullRequest->setId((int)$data->id);
        $pullRequest->setVersion((string)$data->version);
        $pullRequest->setTitle((string)$data->title);
        $pullRequest->setDescription((string)$data->description);
        $pullRequest->setState((string)$data->state);
        $pullRequest->setOpen((bool)$data->open);
        $pullRequest->setClosed((bool)$data->closed);
        $pullRequest->setDateCreated((int)$data->createdDate);
        $pullRequest->setDateUpdated((int)$data->updatedDate);
        if (isset($data->fromRef)) {
            $pullRequest->setFromBranch(BranchMapper::map($data->fromRef));
        }
        if (isset($data->toRef)) {
            $pullRequest->setToBranch(BranchMapper::map($data->toRef));
        }
        $pullRequest->setLocked((bool)$data->locked);
        if (isset($data->author)) {
            $pullRequest->setAuthor(AuthorMapper::map($data->author));
        }
        if (isset($data->reviewers) && is_array($data->reviewers)) {
            $reviewers = [];
            foreach ($data->reviewers as $reviewer) {
                $reviewers[] = AuthorMapper::map($reviewer);
            }
            $pullRequest->setReviewers($reviewers);
        }
        if (isset($data->properties) && $data->properties instanceof \stdClass) {
            $pullRequest->setProperties(get_object_vars($data->properties));
        }
        foreach ($data->links->self as $link) {
            if (isset($link->href)) {
                $pullRequest->setLink((string)$link->href);
                break;
            }
        }
        return $pullRequest;
    }

}