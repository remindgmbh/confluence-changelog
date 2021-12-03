<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Model\Content;

use JsonSerializable;

/**
 *
 */
class ContentBody implements JsonSerializable
{
    /**
     * @var string
     */
    public const REP_VIEW = 'view';

    /**
     * @var string
     */
    public const REP_EXPORT_VIEW = 'export_view';

    /**
     * @var string
     */
    public const REP_STYLED_VIEW = 'styled_view';

    /**
     * @var string
     */
    public const REP_STORAGE = 'storage';

    /**
     * @var string
     */
    public const REP_EDITOR2 = 'editor2';

    /**
     * @var string
     */
    public const REP_ANON_EXPORT_VIEW = 'anonymous_export_view';

    /**
     *
     * @var string
     */
    protected string $value = '';

    /**
     * Valid values: view, export_view, styled_view, storage, editor2, anonymous_export_view
     *
     * @var string
     */
    protected string $representation = '';

    /**
     * Array<EmbeddedContent>
     * Array of ints
     *
     * @var array
     */
    protected array $embeddedContent = [];

    /**
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
        $this->representation = '';
    }

    /**
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'representation' => $this->representation
        ];
    }

    /**
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     *
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     *
     * @return string
     */
    public function getRepresentation(): string
    {
        return $this->representation;
    }

    /**
     *
     * @param string $representation
     * @return void
     */
    public function setRepresentation(string $representation): void
    {
        $this->representation = $representation;
    }
}
