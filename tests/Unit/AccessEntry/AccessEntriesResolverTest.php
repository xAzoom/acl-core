<?php

namespace Xazoom\AclSystem\Tests\Unit\AccessEntry;

use Xazoom\AclSystem\AccessEntry\AccessEntriesResolver;
use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;
use Xazoom\AclSystem\Tests\BaseTestCase;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\DashboardAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;
use Xazoom\AclSystem\Tests\Share\ObjectMother\AccessEntriesResolverMother;

class AccessEntriesResolverTest extends BaseTestCase
{
    public function testResolveByEntryClassType(): void
    {
        $accessEntriesResolver = AccessEntriesResolverMother::allAccessEntries();

        $entryResolver = $accessEntriesResolver->resolve(ArticleAccessEntry::class);

        $this->assertInstanceOf(ArticleAccessEntry::class, $entryResolver);
    }

    public function testResolveByResourceClassType(): void
    {
        $accessEntriesResolver = AccessEntriesResolverMother::allAccessEntries();

        $entryResolver = $accessEntriesResolver->resolve(Article::class);

        $this->assertInstanceOf(ArticleAccessEntry::class, $entryResolver);
    }

    public function testResolveInvalidKey(): void
    {
        $accessEntriesResolver = AccessEntriesResolverMother::allAccessEntries();

        $this->expectException(KeyAccessEntryNotRecognisedException::class);

        $entryResolver = $accessEntriesResolver->resolve('test');
    }
}