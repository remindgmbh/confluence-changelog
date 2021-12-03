<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Model;

use JsonSerializable;
use Remind\ConfluenceChangelog\Model\Content\Body;

/**
 *
 */
class Content implements JsonSerializable
{
    /**
     * @var string
     */
    public const TYPE_PAGE = 'page';

    /**
     * @var string
     */
    public const TYPE_BLOG = 'blogpost';

    /**
     * @var string
     */
    public const STATUS_CURRENT = 'current';

    /**
     * @var string
     */
    public const STATUS_TRASHED = 'trashed';

    /**
     * @var string
     */
    public const STATUS_HISTORICAL = 'historical';

    /**
     * @var string
     */
    public const STATUS_DRAFT = 'draft';

    /**
     *
     * @var string
     */
    protected string $type = self::TYPE_PAGE;

    /**
     *
     * @var string
     */
    protected string $spaceKey = 'TEC';

    /**
     *
     * @var string
     */
    protected string $title = 'Test';

    /**
     *
     * @var string
     */
    protected string $status = self::STATUS_CURRENT;

    /**
     *
     * @var string
     */
    protected string $ancestor = '1266188289';

    /**
     *
     * @var Body|null
     */
    protected ?Body $body = null;

    /**
     *
     */
    public function __construct()
    {
        $this->type = self::TYPE_PAGE;
        $this->spaceKey = '';
        $this->title = '';
        $this->status = self::STATUS_CURRENT;
        $this->ancestor = '';
        $this->body = null;
    }

    /**
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $temp = [
            'type' => $this->type,
            'space' => [ 'key' => $this->spaceKey ],
            'title' => $this->title,
            'status' => $this->status,
            'body' => $this->body
        ];

        if ($this->ancestor !== '') {
            $temp['ancestors'] = [[ 'id' => $this->ancestor ]];
        }

        return $temp;
    }

    /**
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     * @return void
     */
    public function setType(string $type = self::TYPE_PAGE): void
    {
        $this->type = $type;
    }

    /**
     *
     * @return string
     */
    public function getSpaceKey(): string
    {
        return $this->spaceKey;
    }

    /**
     *
     * @param string $key
     * @return void
     */
    public function setSpaceKey(string $key): void
    {
        $this->spaceKey = $key;
    }

    /**
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status = self::STATUS_CURRENT): void
    {
        $this->status = $status;
    }

    /**
     *
     * @return string
     */
    public function getAncestor(): string
    {
        return $this->ancestor;
    }

    /**
     *
     * @param string $id
     * @return void
     */
    public function setAncestor(string $id): void
    {
        $this->ancestor = $id;
    }

    /**
     *
     * @return Body|null
     */
    public function getBody(): ?Body
    {
        return $this->body;
    }

    /**
     *
     * @param Body|null $body
     * @return void
     */
    public function setBody(?Body $body): void
    {
        $this->body = $body;
    }
}
