<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog;

class GitLog
{
    /**
     * Defines the command to list all available git tags.
     * @var string
     */
    public const CMD_GIT_TAGS = 'git for-each-ref --sort="*authordate" --format="%(tag)" refs/tags';

    /**
     * Defines the base command to show all git commit messages.
     * Using %B: raw body (unwrapped subject and body)
     * @var string
     */
    public const CMD_GIT_LOG = 'git log --no-merges --pretty="%B" ';

    /**
     * Regex pattern to match JIRA issues.
     * @var string
     */
    public const PATTERN_ISSUE = '~([A-Z]{2,12})-([0-9]{1,5})~';

    /**
     * The template used by sprintf to generate a jira issue macro.
     * @var string
     */
    public const TEMPLATE_LINK
        = '<p><ac:structured-macro ac:name="jira">'
        . '<ac:parameter ac:name="server">System Jira</ac:parameter>'
        . '<ac:parameter ac:name="serverId">55d1b5b8-fd75-38e3-9511-3fc116e05466</ac:parameter>'
        . '<ac:parameter ac:name="key">%s</ac:parameter>'
        . '</ac:structured-macro></p>';

    /**
     * Contains all tag names.
     *
     * @var array
     */
    protected $tags = [];

    /**
     * Holds the previously processed tag name.
     *
     * @var string
     */
    protected $lastTag = '';

    /**
     * An associative array where the key is the tag name
     * and the values are the generated jira issue macros
     * for each tag name.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Initializes the tag data by executing the git tag command.
     */
    public function __construct()
    {
        $this->lastTag = '';
        $this->data = [];

        exec(self::CMD_GIT_TAGS, $this->tags);
    }

    /**
     * Returns the parsed git log messages for each tag name.
     *
     * @return array
     */
    public function getContent(): array
    {
        $tag = '';

        /* Process each tag into a content representation */
        foreach ($this->tags as $tag) {

            /* Sometimes the git command returns an empty entry */
            if ($tag === '') {
                continue;
            }

            $this->intoContent($this->processTag($tag), $tag);
        }

        /* Generate the commit messages from the last tag name to head */
        $this->intoContent($this->processTag($tag), 'develop');

        return $this->data;
    }

    /**
     *
     * @param string $tag
     * @return array
     */
    protected function processTag(string $tag): array
    {
        $messages = [];

        if ($this->lastTag === '') {
            exec(self::CMD_GIT_LOG . $tag, $messages);
        }

        if ($this->lastTag === $tag) {
            exec(self::CMD_GIT_LOG . $tag . '...', $messages);
        }

        if ($messages === []) {
            exec(self::CMD_GIT_LOG . $this->lastTag . '...' . $tag, $messages);
        }

        $this->lastTag = $tag;

        return $this->processMessages($messages);
    }

    /**
     * @param array $messages
     * @return array
     */
    protected function processMessages(array $messages): array
    {
        $data = [];

        foreach ($messages as $message) {
            $result = preg_match_all(self::PATTERN_ISSUE, $message, $matches);

            if ($result === 0 || $result === false) {
                continue;
            }

            for ($i = 0, $c = count($matches[0]); $i < $c; ++$i) {
                $project = $matches[1][$i] ?? '';
                $id = $matches[2][$i] ?? '';

                if (!isset($data[$project])) {
                    $data[$project] = [];
                }

                if (array_search($id, $data[$project], true) === false) {
                    $data[$project][] = $id;
                }
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $tag
     * @return void
     */
    protected function intoContent(array $data, string $tag): void
    {
        ksort($data);

        foreach ($data as $project => $ids) {
            asort($ids);

            foreach ($ids as $id) {
                $issue = $project . '-' . $id;

                if (!isset($this->data[$tag])) {
                    $this->data[$tag] = '';
                }

                $this->data[$tag] .= sprintf(self::TEMPLATE_LINK, $issue);
            }
        }
    }
}
