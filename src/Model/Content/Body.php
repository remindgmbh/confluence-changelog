<?php

namespace Remind\ConfluenceChangelog\Model\Content;

use \JsonSerializable;
use \Remind\ConfluenceChangelog\Model\Content\ContentBody;

class Body implements JsonSerializable
{
    protected ?ContentBody $view = null;

    protected ?ContentBody $exportView = null;

    protected ?ContentBody $styledView = null;

    protected ?ContentBody $storage = null;

    protected ?ContentBody $editor2 = null;

    public function __construct()
    {
        $this->view = null;
        $this->exportView = null;
        $this->styledView = null;
        $this->storage = null;
        $this->editor2 = null;
    }

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

    public function getView(): ?ContentBody
    {
        return $this->view;
    }

    public function setView(?ContentBody $view): void
    {
        if ($view !== null) {
            $view->setRepresentation(ContentBody::REP_VIEW);
        }

        $this->view = $view;
    }

    public function getExportView(): ?ContentBody
    {
        return $this->exportView;
    }

    public function setExportView(?ContentBody $exportView): void
    {
        if ($exportView !== null) {
            $exportView->setRepresentation(ContentBody::REP_EXPORT_VIEW);
        }

        $this->exportView = $exportView;
    }

    public function getStyledView(): ?ContentBody
    {
        return $this->styledView;
    }

    public function setStyledView(?ContentBody $styledView): void
    {
        if ($styledView !== null) {
            $styledView->setRepresentation(ContentBody::REP_STYLED_VIEW);
        }

        $this->styledView = $styledView;
    }

    public function getStorage(): ?ContentBody
    {
        return $this->storage;
    }

    public function setStorage(?ContentBody $storage): void
    {
        if ($storage !== null) {
            $storage->setRepresentation(ContentBody::REP_STORAGE);
        }

        $this->storage = $storage;
    }

    public function getEditor2(): ?ContentBody
    {
        return $this->editor2;
    }

    public function setEditor2(?ContentBody $editor2): void
    {
        if ($editor2 !== null) {
            $editor2->setRepresentation(ContentBody::REP_EDITOR2);
        }

        $this->editor2 = $editor2;
    }
}
