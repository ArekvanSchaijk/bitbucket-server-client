<?php
namespace ArekvanSchaijk\BitbucketServerClient;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\CommitMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\ProjectMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\RepositoryMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;
use GuzzleHttp\Client;

/**
 * Class Api
 * @package ArekvanSchaijk\BitbucketServerClient
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Api
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    static protected $endpoint;

    /**
     * @var array
     */
    static protected $auth = [];

    /**
     * Sets the Endpoint
     *
     * @param string $endpoint
     * @return void
     */
    public function setEndpoint($endpoint)
    {
        self::$endpoint = rtrim($endpoint, '/');
    }

    /**
     * Login
     *
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        self::$auth = ['auth' => [$username, $password]];
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        self::$auth = [];
    }

    /**
     * Gets the Client
     *
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }
        return $this->client;
    }

    /**
     * Gets the Projects
     *
     * @param int $limit
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Project>
     */
    public function getProjects($limit = 1000)
    {
        $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/1.0/projects?limit=' . $limit, self::$auth);
        return new ProjectMapper($response);
    }

    /**
     * Gets the Repositories
     *
     * @param string $projectKey
     * @param int $limit
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository>
     */
    public function getRepositoriesByProject($projectKey, $limit = 1000)
    {
        $response = $this->getClient()->request('GET',
            self::$endpoint . sprintf('/rest/api/1.0/projects/%s/repos?limit=' . $limit, $projectKey), self::$auth);
        return new RepositoryMapper($response);
    }

    /**
     * Gets the Commits
     *
     * @param Repository $repository
     * @param string $branchName
     * @param int $limit
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Commit>
     */
    public function getCommits(Repository $repository, $branchName = 'master', $limit = 1000)
    {
        $response = $this->getClient()->request('GET',
            self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug() . '/commits/?until=' .
                $branchName .'&limit=' . $limit, self::$auth);
        return new CommitMapper($response);
    }

}