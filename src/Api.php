<?php
namespace ArekvanSchaijk\BitbucketServerClient;

use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\ProjectMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository\BranchMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository\CommitMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\Repository\PullRequestMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Data\Mapper\RepositoryMapper;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Author;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Project;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\Branch;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\PullRequest;
use ArekvanSchaijk\BitbucketServerClient\Api\Entity\User;
use ArekvanSchaijk\BitbucketServerClient\Api\Exception\ConflictException;
use ArekvanSchaijk\BitbucketServerClient\Api\Exception\UnauthorizedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

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
    static protected $options = [];

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
        self::$options = array_merge(self::$options, ['auth' => [$username, $password]]);
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        self::$options = [];
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
            $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/1.0/projects?limit='
                . $limit, self::$options);
            return new ProjectMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Creates a new Project
     *
     * @param Project $project
     * @return Project
     */
    public function createProject(Project $project)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'key' => $project->getKey(),
                'name' => $project->getName()
            ]
        ]);
        try {
            $response = $this->getClient()->request('POST', self::$endpoint . '/rest/api/1.0/projects?create', $options);
            return self::mapSingleResponse($response, ProjectMapper::class);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Create Repository
     *
     * @param Project $project
     * @param Repository $repository
     * @return Repository
     */
    public function createRepository(Project $project, Repository $repository = null)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'name' => $repository->getName()
            ]
        ]);
        try {
            $response = $this->getClient()->request('POST', self::$endpoint . '/rest/api/1.0/projects/'
                . $project->getKey() . '/repos?create', $options);
            return self::mapSingleResponse($response, RepositoryMapper::class);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Creates a Repository Branch
     *
     * @param Repository $repository
     * @param Branch $branchFrom
     * @param string $branchName
     * @return Branch
     */
    public function createRepositoryBranch(Repository $repository, Branch $branchFrom, $branchName)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'name' => $branchName,
                'startPoint' => $branchFrom->getId(),
            ]
        ]);
        try {
            $response = $this->getClient()->request('POST', self::$endpoint . '/rest/branch-utils/latest/projects/'
                . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug() . '/branches', $options);
            return self::mapSingleResponse($response, BranchMapper::class);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Create Repository HipChat Integration
     *
     * @param Repository $repository
     * @param int $roomId
     * @return void
     */
    public function createRepositoryHipChatIntegration(Repository $repository, $roomId)
    {
        try {
            $this->getClient()->request('PUT', self::$endpoint . '/rest/hipchat-integrations/latest/'
                . 'projects/' . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug() . '/rooms/'
                . $roomId, self::$options);
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
                self::$endpoint . sprintf('/rest/api/1.0/projects/%s/repos?limit=' . $limit, $projectKey), self::$options);
            return new RepositoryMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Gets the Pull Requests By Repository
     *
     * @param Repository $repository
     * @param string|null $state
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\PullRequest>
     */
    public function getPullRequestsByRepository(Repository $repository, $state = null)
    {
        $state = ($state ?: PullRequest::STATE_OPEN);
        try {
            $response = $this->getClient()->request('GET',
                self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug() . '/pull-requests?' . $state, self::$options);
            return new PullRequestMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Creates a new PullRequest
     *
     * @param Repository $repository
     * @param string $title
     * @param string $description
     * @param Branch $fromBranch
     * @param Branch $toBranch
     * @param User[] $reviewers
     * @return PullRequest
     */
    public function createPullRequest(Repository $repository, $title, $description = '', Branch $fromBranch, Branch $toBranch, array $reviewers = [])
    {
        $options = array_merge(self::$options, [
            'json' => [
                'title' => $title,
                'description' => $description,
                'state' => PullRequest::STATE_OPEN,
                'closed' => false,
                'fromRef' => [
                    'id' => $fromBranch->getId(),
                    'name' => null,
                    'project' => [
                        'key' => $repository->getProject()->getKey()
                    ]
                ],
                'toRef' => [
                    'id' => $toBranch->getId(),
                    'name' => null,
                    'project' => [
                        'key' => $repository->getProject()->getKey()
                    ]
                ],
                'locked' => false,
                'links' => [
                    'self' => [
                        null
                    ]
                ]
            ]
        ]);
        // Adds the reviewers
        if ($reviewers) {
            $users = [];
            foreach ($reviewers as $reviewer) {
                $users[]['user']['name'] = $reviewer->getName();
            }
            $options['json']['reviewers'] = $users;
        }
        try {
            $response = $this->getClient()->request('POST', self::$endpoint . '/rest/api/1.0/projects/'
                . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug()
                . '/pull-requests?create', $options);
            return self::mapSingleResponse($response, PullRequestMapper::class);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Merge Pull Request
     *
     * @param Repository $repository
     * @param PullRequest $pullRequest
     * @return void
     */
    public function mergePullRequest(Repository $repository, PullRequest $pullRequest)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'version' => $pullRequest->getVersion(),
                'message' => ''
            ],
        ]);
        try {
            $this->getClient()->request('POST', self::$endpoint . '/rest/api/latest/projects/'
                . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug() . '/pull-requests/'
                . $pullRequest->getId() . '/merge', $options);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Decline Pull Request
     *
     * @param Repository $repository
     * @param PullRequest $pullRequest
     * @return void
     */
    public function declinePullRequest(Repository $repository, PullRequest $pullRequest)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'version' => $pullRequest->getVersion()
            ],
        ]);
        try {
            $this->getClient()->request('POST', self::$endpoint . '/rest/api/latest/projects/'
                . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug() . '/pull-requests/'
                . $pullRequest->getId() . '/decline', $options);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Reopen Pull Request
     *
     * @param Repository $repository
     * @param PullRequest $pullRequest
     * @return void
     */
    public function reopenPullRequest(Repository $repository, PullRequest $pullRequest)
    {
        $options = array_merge(self::$options, [
            'json' => [
                'version' => $pullRequest->getVersion()
            ]
        ]);
        try {
            $this->getClient()->request('POST', self::$endpoint . '/rest/api/latest/projects/'
                . $repository->getProject()->getKey() . '/repos/' . $repository->getSlug() . '/pull-requests/'
                . $pullRequest->getId() . '/reopen', $options);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Gets the Repository Branches
     *
     * @param Repository $repository
     * @return \SplObjectStorage<\ArekvanSchaijk\BitbucketServerClient\Api\Entity\Repository\PullRequest>
     */
    public function getRepositoryBranches(Repository $repository)
    {
        try {
            $response = $this->getClient()->request('GET',
                self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug() . '/branches', self::$options);
            return new BranchMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Delete Repository
     *
     * @param Repository $repository
     * @return void
     */
    public function deleteRepository(Repository $repository)
    {
        try {
            $this->getClient()->request('DELETE',
                self::$endpoint . '/rest/api/1.0/projects/' . $repository->getProject()->getKey() .
                '/repos/' . $repository->getSlug(), self::$options);
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
                $branchName . '&limit=' . $limit, self::$options);
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
     * @throws ConflictException
     * @throws Exception
     * @throws UnauthorizedException
     */
    protected function exceptionHandler(\Exception $exception)
    {
        if ($exception instanceof ClientException) {
            $statusCode = $exception->getResponse()->getStatusCode();
            // Tries to resolve the initial error message by Atlassian
            $errorMessage = null;
            try {
                $json = \GuzzleHttp\json_decode($exception->getResponse()->getBody());
                $errorMessage = (isset($json->errors[0]->message) ? $json->errors[0]->message : null);
            } catch (\Exception $jsonDecodeException) {
                // Here we do just nothing ;)
            }
            switch ($statusCode) {
                case 401:
                    throw new UnauthorizedException(($errorMessage ?: $exception));
                    break;
                case 409:
                    throw new ConflictException(($errorMessage ?: $exception));
                    break;
                default:
                    throw new Exception(($errorMessage ?: $exception));
            }
        }
        throw new Exception($exception);
    }

    /**
     * Maps Single Response
     *
     * @param Response $response
     * @param string $mapper
     * @return mixed
     * @static
     */
    static public function mapSingleResponse(Response $response, $mapper)
    {
        return $mapper::map(\GuzzleHttp\json_decode($response->getBody()));
    }

}