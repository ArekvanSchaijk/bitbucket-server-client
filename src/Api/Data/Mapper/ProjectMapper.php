<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Project;

/**
 * Class ProjectMapper
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
     * @return Project
     * @static
     */
    static public function map($data)
    {
        $project = new Project();
        $project->setKey((string)$data->key);
        $project->setId((int)$data->id);
        $project->setName((string)$data->name);
        $project->setIsPublic((bool)$data->public);
        $project->setType((string)$data->type);
        $project->setLink((string)$data->links->self[0]->href);
        return $project;
    }

}