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
                foreach ($data->values as $data) {
                    $this->attach(
                        self::map($data)
                    );
                }
            }
        }
    }

    /**
     * Map
     *
     * @param mixed $data
     * @return Repository
     * @static
     */
    static public function map($data) {
        $repository = new Repository();
        $repository->setId((int)$data->id);
        $repository->setName((string)$data->name);
        $repository->setIsPublic((bool)$data->public);
        $repository->setIsForkable((bool)$data->forkable);
        $repository->setSlug((string)$data->slug);
        $repository->setScmId((string)$data->scmId);
        $repository->setState((string)$data->state);
        $repository->setStatusMessage((string)$data->statusMessage);
        $repository->setLink((string)$data->links->self[0]->href);
        if ($data->project) {
            $repository->setProject(
                ProjectMapper::map($data->project)
            );
        }
        foreach ($data->links->clone as $cloneUrl) {
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
        return $repository;
    }

}