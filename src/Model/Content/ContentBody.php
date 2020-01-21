<?php

namespace Remind\ConfluenceChangelog\Model\Content;

use \JsonSerializable;

class ContentBody implements JsonSerializable
{
    const REP_VIEW = 'view';

    const REP_EXPORT_VIEW = 'export_view';

    const REP_STYLED_VIEW = 'styled_view';

    const REP_STORAGE = 'storage';

    const REP_EDITOR2 = 'editor2';

    const REP_ANON_EXPORT_VIEW = 'anonymous_export_view';

    protected string $value = '';

    // Valid values: view, export_view, styled_view, storage, editor2, anonymous_export_view
    protected string $representation = '';

    /**
     * Array<EmbeddedContent>
     * Array of ints
     */
    protected array $embeddedContent = [];

    // WebResourceDependencies
    protected $webresource = null;

    // object
    protected $_expandable = null;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->representation = '';
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'representation' => $this->representation
        ];
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getRepresentation(): string
    {
        return $this->representation;
    }

    public function setRepresentation(string $representation): void
    {
        $this->representation = $representation;
    }
}
