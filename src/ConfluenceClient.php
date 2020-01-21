<?php

namespace Remind\ConfluenceChangelog;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\ClientException;
use \GuzzleHttp\Psr7\Request;
use \Remind\ConfluenceChangelog\GitLog;
use \Remind\ConfluenceChangelog\Model\Content;
use \Remind\ConfluenceChangelog\Model\Content\Body;
use \Remind\ConfluenceChangelog\Model\Content\ContentBody;
use \Symfony\Component\Console\Output\OutputInterface;
use function \GuzzleHttp\Psr7\stream_for;

/**
 * ConfluenceClient
 */
class ConfluenceClient
{
    /**
     * @var string
     */
    const ANCESTOR_DEFAULT = 'Changelog';

    /**
     * @var string
     */
    protected string $token = '';

    /**
     * @var string
     */
    protected string $spaceKey = '';

    /**
     * @var string
     */
    protected string $ancestorName = self::ANCESTOR_DEFAULT;

    /**
     * @var string
     */
    protected string $ancestorId = '';

    /**
     * @var Client|null
     */
    protected ?Client $client = null;

    /**
     * @var OutputInterface|null
     */
    protected ?OutputInterface $output = null;

    /**
     * @param string $token
     * @param string $spaceKey
     * @param string $uri
     * @param string $ancestor
     */
    public function __construct(string $token, string $spaceKey, string $uri, string $ancestor = self::ANCESTOR_DEFAULT)
    {
        $this->token = $token;
        $this->spaceKey = $spaceKey;
        $this->ancestorName = $ancestor !== '' ? $ancestor : self::ANCESTOR_DEFAULT;
        $this->ancestorId = '';

        $this->client = new Client([ 'base_uri' => $uri ]);

        $this->output = null;
    }

    /**
     * @return int
     */
    public function save(): int
    {
        $log = new GitLog();

        $data = $log->getContent();

        if (count($data) === 0) {
            return 1;
        }

        if ($this->ancestorId === '') {
            $this->getAncestor();
        }

        foreach ($data as $tag => $content) {
            $this->updateTagPage($tag, $content);
        }

        return 0;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function applyRequestParams(Request $request): Request
    {
        return $request
            ->withHeader('Authorization', 'Basic ' . $this->token)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @return void
     */
    protected function getAncestor(): void
    {
        $uri = sprintf('content?spaceKey=%s&title=%s&limit=1', $this->spaceKey, $this->ancestorName);

        $request = $this->applyRequestParams(new Request('GET', $uri));

        $response = null;

        try {
            $response = $this->client->send($request);

            $data = json_decode($response->getBody(), true);

            if (count($data['results']) !== 1) {
                $this->createChangelogPage();
            }
        } catch (ClientException $e) {
            $this->createChangelogPage();
        }

        if ($this->ancestorId !== '') {
            return;
        }

        $data = json_decode($response->getBody(), true);

        $this->ancestorId = $data['results'][0]['id'] ?? '';
    }

    /**
     * @return void
     */
    protected function createChangelogPage(): void
    {
        $request = $this->applyRequestParams(new Request('POST', 'content'));

        $content = new Content();

        $content->setSpaceKey($this->spaceKey);
        $content->setTitle($this->ancestorName);

        $request = $request->withBody(
            stream_for(json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
        );

        try {
            $response = $this->client->send($request);

            $data = json_decode($response->getBody(), true);

            $this->ancestorId = $data['id'] ?? '';
        } catch (ClientException $e) {

            if ($this->output !== null) {
                $this->output->writeln('Could not fetch or create changelog page');
            }
        }
    }

    /**
     * @param string $tag
     * @param string $content
     * @return void
     */
    protected function updateTagPage(string $tag, string $content): void
    {
        $request = $this->applyRequestParams(new Request('POST', 'content'));

        $storageBody = new ContentBody('<h1>Änderungen</h1>' . $content);

        $body = new Body();
        $body->setStorage($storageBody);

        $content = new Content();
        $content->setSpaceKey($this->spaceKey);
        $content->setTitle($tag);
        $content->setAncestor($this->ancestorId);
        $content->setBody($body);

        $request = $request->withBody(
            stream_for(json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
        );

        try {
            $this->client->send($request);
        } catch (ClientException $e) {
            if ($this->output !== null) {

                $response = $e->getResponse();

                if ($response !== null) {
                    $data = json_decode($response->getBody(), true);

                    $message = $data['message'] ?? $response->getBody();

                    if (stripos($message, 'A page with this title already exists') === false) {

                        if ($this->output !== null) {
                            $this->output->writeln($message);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param OutputInterface $output
     * @return void
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}
