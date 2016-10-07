<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Project;

/**
 * Class ProjectMapper
 * @package ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class ProjectMapper extends Adapter
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
            foreach ($values as $value) {
                $project = new Project();
                $project->setKey((string)$value->key);
                $project->setId((int)$value->id);
                $project->setName((string)$value->name);
                $project->setIsPublic((bool)$value->public);
                $project->setType((string)$value->type);
                $project->setLink((string)$value->links->self[0]->href);
                $this->attach($project);
            }
        }
    }

}