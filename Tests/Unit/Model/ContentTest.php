<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use Remind\ConfluenceChangelog\Model\Content;
use Remind\ConfluenceChangelog\Model\Content\Body;

/**
 * Description of ContentTest
 */
final class ContentTest extends TestCase
{
    public function testCanSetAncestor(): void
    {
        $subject = new Content();
        $subject->setAncestor('test');

        $this->assertEquals('test', $subject->getAncestor());
    }

    public function testCanSetBody(): void
    {
        $body = new Body();

        $subject = new Content();
        $subject->setBody($body);

        $this->assertEquals($body, $subject->getBody());
    }

    public function testCanSetSpaceKey(): void
    {
        $subject = new Content();
        $subject->setSpaceKey('TEST');

        $this->assertEquals('TEST', $subject->getSpaceKey());
    }

    public function testCanGetStatusDefault(): void
    {
        $subject = new Content();

        $this->assertEquals(Content::STATUS_CURRENT, $subject->getStatus());
    }

    public function testCanResetStatus(): void
    {
        $subject = new Content();
        $subject->setStatus(Content::STATUS_TRASHED);
        $subject->setStatus();

        $this->assertEquals(Content::STATUS_CURRENT, $subject->getStatus());
    }

    public function testCanSetStatus(): void
    {
        $subject = new Content();
        $subject->setStatus(Content::STATUS_HISTORICAL);

        $this->assertEquals(Content::STATUS_HISTORICAL, $subject->getStatus());
    }

    public function testCanSetTitle(): void
    {
        $subject = new Content();
        $subject->setTitle('Test');

        $this->assertEquals('Test', $subject->getTitle());
    }

    public function testCanGetTypeDefault(): void
    {
        $subject = new Content();

        $this->assertEquals(Content::TYPE_PAGE, $subject->getType());
    }

    public function testCanResetType(): void
    {
        $subject = new Content();
        $subject->setType(Content::TYPE_BLOG);
        $subject->setType();

        $this->assertEquals(Content::TYPE_PAGE, $subject->getType());
    }

    public function testCanSetType(): void
    {
        $subject = new Content();
        $subject->setType(Content::TYPE_BLOG);

        $this->assertEquals(Content::TYPE_BLOG, $subject->getType());
    }
}
