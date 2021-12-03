<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Model\Content;

use JsonSerializable;

/**
 *
 */
class Body implements JsonSerializable
{
    /**
     *
     * @var ContentBody|null
     */
    protected ?ContentBody $view = null;

    /**
     *
     * @var ContentBody|null
     */
    protected ?ContentBody $exportView = null;

    /**
     *
     * @var ContentBody|null
     */
    protected ?ContentBody $styledView = null;

    /**
     *
     * @var ContentBody|null
     */
    protected ?ContentBody $storage = null;

    /**
     *
     * @var ContentBody|null
     */
    protected ?ContentBody $editor2 = null;

    /**
     *
     */
    public function __construct()
    {
        $this->view = null;
        $this->exportView = null;
        $this->styledView = null;
        $this->storage = null;
        $this->editor2 = null;
    }

    /**
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $temp = [];

        if ($this->view !== null) {
            $temp['view'] = $this->view;
        }

        if ($this->exportView !== null) {
            $temp['exportView'] = $this->exportView;
        }

        if ($this->styledView !== null) {
            $temp['styledView'] = $this->styledView;
        }

        if ($this->storage !== null) {
            $temp['storage'] = $this->storage;
        }

        if ($this->editor2 !== null) {
            $temp['editor2'] = $this->editor2;
        }

        return $temp;
    }

    /**
     *
     * @return ContentBody|null
     */
    public function getView(): ?ContentBody
    {
        return $this->view;
    }

    /**
     *
     * @param ContentBody|null $view
     * @return void
     */
    public function setView(?ContentBody $view): void
    {
        if ($view !== null) {
            $view->setRepresentation(ContentBody::REP_VIEW);
        }

        $this->view = $view;
    }

    /**
     *
     * @return ContentBody|null
     */
    public function getExportView(): ?ContentBody
    {
        return $this->exportView;
    }

    /**
     *
     * @param ContentBody|null $exportView
     * @return void
     */
    public function setExportView(?ContentBody $exportView): void
    {
        if ($exportView !== null) {
            $exportView->setRepresentation(ContentBody::REP_EXPORT_VIEW);
        }

        $this->exportView = $exportView;
    }

    /**
     *
     * @return ContentBody|null
     */
    public function getStyledView(): ?ContentBody
    {
        return $this->styledView;
    }

    /**
     *
     * @param ContentBody|null $styledView
     * @return void
     */
    public function setStyledView(?ContentBody $styledView): void
    {
        if ($styledView !== null) {
            $styledView->setRepresentation(ContentBody::REP_STYLED_VIEW);
        }

        $this->styledView = $styledView;
    }

    /**
     *
     * @return ContentBody|null
     */
    public function getStorage(): ?ContentBody
    {
        return $this->storage;
    }

    /**
     *
     * @param ContentBody|null $storage
     * @return void
     */
    public function setStorage(?ContentBody $storage): void
    {
        if ($storage !== null) {
            $storage->setRepresentation(ContentBody::REP_STORAGE);
        }

        $this->storage = $storage;
    }

    /**
     *
     * @return ContentBody|null
     */
    public function getEditor2(): ?ContentBody
    {
        return $this->editor2;
    }

    /**
     *
     * @param ContentBody|null $editor2
     * @return void
     */
    public function setEditor2(?ContentBody $editor2): void
    {
        if ($editor2 !== null) {
            $editor2->setRepresentation(ContentBody::REP_EDITOR2);
        }

        $this->editor2 = $editor2;
    }
}
