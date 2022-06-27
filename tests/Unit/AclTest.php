<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Tests\Unit;

use Xazoom\AclSystem\Acl;
use Xazoom\AclSystem\Tests\BaseTestCase;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;
use Xazoom\AclSystem\Tests\Share\ObjectMother\UserMother;
use Xazoom\AclSystem\Tests\Share\TestDoubles\Fake\AccessResolverFake;

/**
 * @internal
 * @coversNothing
 */
final class AclTest extends BaseTestCase
{
    public function testFalseAccessIfNullIdentity(): void
    {
        $accessResolver = new AccessResolverFake([false]);
        $acl = new Acl($accessResolver);

        $hasAccess = $acl->hasAccess(null, new Article(), 'READ');

        static::assertFalse($hasAccess);
        static::assertCount(0, $accessResolver->logs);
    }

    public function testUseExactOneAccessResolver(): void
    {
        $accessResolver = new AccessResolverFake([true]);
        $user = UserMother::withFullArticleAccess();
        $acl = new Acl($accessResolver);

        $hasAccess = $acl->hasAccess($user, ArticleAccessEntry::key(), ArticleAccessEntry::READ);

        static::assertTrue($hasAccess);
        static::assertCount(1, $accessResolver->logs);
        static::assertSame($user, $accessResolver->logs[0]['identity']);
        static::assertSame(ArticleAccessEntry::key(), $accessResolver->logs[0]['resource']);
        static::assertSame(ArticleAccessEntry::READ, $accessResolver->logs[0]['attribute']);
    }
}
