<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;

/**
 * Class ProjectMapper
 * @package ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class RepositoryMapper extends Adapter
{

    /**
     * Process
     *
     * @return void
     */
    protected function process()
    {
        if (($data = $this->json())) {
            if ($data->values) {
                foreach ($data->values as $value) {
                    $repository = new Repository();
                    $repository->setId((int)$value->id);
                    $repository->setName((string)$value->name);
                    $repository->setIsPublic((bool)$value->public);
                    $repository->setIsForkable((bool)$value->forkable);
                    $repository->setSlug((string)$value->slug);
                    $repository->setScmId((string)$value->scmId);
                    $repository->setState((string)$value->state);
                    $repository->setStatusMessage((string)$value->statusMessage);
                    $repository->setLink((string)$value->links->self[0]->href);
                    foreach ($value->links->clone as $cloneUrl) {
                        switch ($cloneUrl->name) {
                            case 'http':
                                $repository->setCloneUrl($cloneUrl->href);
                                break;
                            case 'ssh':
                                $repository->setSshCloneUrl($cloneUrl->href);
                                break;
                            default:
                        }
                    }
                    $this->attach($repository);
                }
            }
        }
    }

}