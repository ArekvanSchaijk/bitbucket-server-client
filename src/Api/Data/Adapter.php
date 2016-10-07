<?php
namespace ArekvanSchaijk\BitbucketServerClient\Api\Data;

use GuzzleHttp;
use GuzzleHttp\Psr7\Response;

/**
 * Class Adapter
 * @package ArekvanSchaijk\BitbucketServerClient\Api\Data
 * @author Arek van Schaijk <info@ucreation.nl>
 */
abstract class Adapter extends \SplObjectStorage
{

    abstract protected function process();

    /**
     * @var null|Response
     */
    protected $response;

    /**
     * @var null|array
     */
    protected $json;

    /**
     * ProjectMapper constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->process();
        unset(
            $this->response,
            $this->json
        );
    }

    /**
     * JSON
     *
     * @return array
     */
    protected function json()
    {
        if (is_null($this->json)) {
            $this->json = GuzzleHttp\json_decode($this->response->getBody());
        }
        return $this->json;
    }

}