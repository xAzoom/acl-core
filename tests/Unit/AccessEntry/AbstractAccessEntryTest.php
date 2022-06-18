<?php

namespace Xazoom\AclSystem\Tests\Unit\AccessEntry;

use Xazoom\AclSystem\AccessEntry\Exception\UnsupportedAttributeException;
use Xazoom\AclSystem\Tests\BaseTestCase;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;
use Xazoom\AclSystem\Tests\Share\ObjectMother\UserMother;

class AbstractAccessEntryTest extends BaseTestCase
{
    public function testSuccessResolveAccess(): void
    {
        $articleAccessEntry = new ArticleAccessEntry();
        $user = UserMother::withFullArticleAccess();
        $article = new Article();

        $hasAccess = $articleAccessEntry->resolveAccess($user, $article, ArticleAccessEntry::READ);

        $this->assertTrue($hasAccess);
    }

    public function testTryingAccessToUnsupportedAttribute(): void
    {
        $this->expectException(UnsupportedAttributeException::class);

        $articleAccessEntry = new ArticleAccessEntry();
        $user = UserMother::withFullArticleAccess();
        $article = new Article();

        $hasAccess = $articleAccessEntry->resolveAccess($user, $article, 'test');
    }
}