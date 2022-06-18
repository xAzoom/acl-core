<?php

namespace Xazoom\AclSystem\Tests\Unit;

use Xazoom\AclSystem\Acl;
use Xazoom\AclSystem\Tests\BaseTestCase;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;
use Xazoom\AclSystem\Tests\Share\ObjectMother\UserMother;
use Xazoom\AclSystem\Tests\Share\TestDoubles\Fake\AccessResolverFake;

class AclTest extends BaseTestCase
{
    public function testFalseAccessIfNullIdentity(): void
    {
        $accessResolver = new AccessResolverFake([false]);
        $acl = new Acl($accessResolver);

        $hasAccess = $acl->hasAccess(null, new Article(), 'READ');

        $this->assertFalse($hasAccess);
        $this->assertCount(0, $accessResolver->logs);
    }

    public function testUseExactOneAccessResolver(): void
    {
        $accessResolver = new AccessResolverFake([true]);
        $user = UserMother::withFullArticleAccess();
        $acl = new Acl($accessResolver);

        $hasAccess = $acl->hasAccess($user, ArticleAccessEntry::key(), ArticleAccessEntry::READ);

        $this->assertTrue($hasAccess);
        $this->assertCount(1, $accessResolver->logs);
        $this->assertEquals($user, $accessResolver->logs[0]['identity']);
        $this->assertEquals(ArticleAccessEntry::key(), $accessResolver->logs[0]['resource']);
        $this->assertEquals(ArticleAccessEntry::READ, $accessResolver->logs[0]['attribute']);
    }
}