<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\RepositoryMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Branch;

/**
 * Class BranchMapper
 * @package ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class BranchMapper extends Adapter
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
     * @return Branch
     * @static
     */
    static public function map($data)
    {
        $branch = new Branch();
        $branch->setId((string)$data->id);
        $branch->setName((string)$data->displayId);
        if (isset($data->type)) {
            $branch->setType((string)$data->type);
        }
        if (isset($data->isDefault)) {
            $branch->setIsDefault((bool)$data->isDefault);
        }
        if (isset($data->repository)) {
            $branch->setRepository(
                RepositoryMapper::map($data->repository)
            );
        }
        return $branch;
    }

}