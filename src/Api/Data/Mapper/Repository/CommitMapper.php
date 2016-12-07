<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Adapter;

/**
 * Class CommitMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class CommitMapper extends Adapter
{

    /**
     * Process
     *
     * @return void
     */
    protected function process()
    {
        $data = $this->json();
        echo '<pre>';
        print_r($data);
        echo '</pre>';

    }

}