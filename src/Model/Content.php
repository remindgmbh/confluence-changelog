<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Model;

use \JsonSerializable;
use \Remind\ConfluenceChangelog\Model\Content\Body;

class Content implements JsonSerializable
{
    const TYPE_PAGE = 'page';

    const TYPE_BLOG = 'blogpost';

    const STATUS_CURRENT = 'current';

    const STATUS_TRASHED = 'trashed';

    const STATUS_HISTORICAL = 'historical';

    const STATUS_DRAFT = 'draft';

    /**
     * @var string
     */
    protected $type = self::TYPE_PAGE;

    /**
     * @var string
     */
    protected $spaceKey = 'TEC';

    /**
     * @var string
     */
    protected $title = 'Test';

    /**
     * @var string
     */
    protected $status = self::STATUS_CURRENT;

    /**
     * @var string
     */
    protected $ancestor = '1266188289';

    /**
     * @var Body|null
     */
    protected $body = null;

    public function __construct()
    {
        $this->type = self::TYPE_PAGE;
        $this->spaceKey = '';
        $this->title = '';
        $this->status = self::STATUS_CURRENT;
        $this->ancestor = '';
        $this->body = null;
    }

    public function jsonSerialize(): array
    {
        $temp = [
            'type'=> $this->type,
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type = self::TYPE_PAGE): void
    {
        $this->type = $type;
    }

    public function getSpaceKey(): string
    {
        return $this->spaceKey;
    }

    public function setSpaceKey(string $key): void
    {
        $this->spaceKey = $key;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status = self::STATUS_CURRENT): void
    {
        $this->status = $status;
    }

    public function getAncestor(): string
    {
        return $this->ancestor;
    }

    public function setAncestor(string $id): void
    {
        $this->ancestor = $id;
    }

    public function getBody(): ?Body
    {
        return $this->body;
    }

    public function setBody(?Body $body): void
    {
        $this->body = $body;
    }
}
