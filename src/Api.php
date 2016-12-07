<?php
namespace ArekvanSchaijk\BitbucketServerClient;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\ProjectMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository\BranchMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository\CommitMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\RepositoryMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;
use ArekvanSchaijk\BitbucketServerClient\Api\Exception\UnauthorizedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Api
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
        try {
            $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/1.0/projects?limit=' . $limit, self::$auth);
            return new ProjectMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
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
        try {
            $response = $this->getClient()->request('GET',
                self::$endpoint . sprintf('/rest/api/1.0/projects/%s/repos?limit=' . $limit, $projectKey), self::$auth);
            return new RepositoryMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Gets the Repository Branches
     *
     * @param Repository $repository
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Branch>
     */
    public function getRepositoryBranches(Repository $repository)
    {
        try {
            $response = $this->getClient()->request('GET',
                self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug() . '/branches', self::$auth);
            return new BranchMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
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
        try {
            $response = $this->getClient()->request('GET',
                self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug() . '/commits/?until=' .
                $branchName . '&limit=' . $limit, self::$auth);
            return new CommitMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Exception Handler
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     * @throws UnauthorizedException
     */
    protected function exceptionHandler(\Exception $exception)
    {
        if ($exception instanceof ClientException) {
            if ($exception->getResponse()->getStatusCode() === 401) {
                $json = null;
                try {
                    $json = \GuzzleHttp\json_decode($exception->getResponse()->getBody());
                } catch (\Exception $jsonDecodeException) {
                    // Just doesn't do anything while the general exception can be thrown
                }
                if (isset($json->errors[0]->message)) {
                    throw new UnauthorizedException($json->errors[0]->message);
                }
                throw new UnauthorizedException($exception);
            }
        }
        throw $exception;
    }

}