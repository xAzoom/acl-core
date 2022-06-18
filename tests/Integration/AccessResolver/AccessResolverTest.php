<?php

namespace Xazoom\AclSystem\Tests\Integration\AccessResolver;

use Xazoom\AclSystem\Entity\AclRole;
use Xazoom\AclSystem\Entity\ValueObject\AccessList;
use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;
use Xazoom\AclSystem\Tests\BaseTestCase;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\DashboardAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\InvalidAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\OwnKeyAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;
use Xazoom\AclSystem\Tests\Share\Entity\User;
use Xazoom\AclSystem\Tests\Share\ObjectMother\AccessResolverMother;
use Xazoom\AclSystem\Tests\Share\ObjectMother\AclRoleMother;
use Xazoom\AclSystem\Tests\Share\ObjectMother\UserMother;

class AccessResolverTest extends BaseTestCase
{
    /** @dataProvider providerHasAccess */
    public function testHasAccess(bool $expected, User $user, $resource, string $attribute): void
    {
        $accessResolver = AccessResolverMother::create();

        $hasAccess = $accessResolver->hasAccess($user, $resource, $attribute);

        $this->assertEquals($expected, $hasAccess);
    }

    public function providerHasAccess(): array
    {
        return [
            //expected, user, resource, attribute
            [true, UserMother::withReadArticleAccess(), new Article(), ArticleAccessEntry::READ],
            [true, UserMother::withReadArticleAccess(), ArticleAccessEntry::class, ArticleAccessEntry::READ],
            [false, UserMother::withReadArticleAccess(), new Article(), ArticleAccessEntry::EDIT],
            [false, UserMother::withReadArticleAccess(), ArticleAccessEntry::class, ArticleAccessEntry::EDIT],
            [true, UserMother::withFullArticleAccess(), ArticleAccessEntry::class, ArticleAccessEntry::READ],
            [true, UserMother::withFullArticleAccess(), ArticleAccessEntry::class, ArticleAccessEntry::EDIT],
        ];
    }

    public function testTryingCheckAccessForNotExistingKey(): void
    {
        $this->expectException(KeyAccessEntryNotRecognisedException::class);

        $accessResolver = AccessResolverMother::create();
        $user = UserMother::withFullArticleAccess();

        $hasAccess = $accessResolver->hasAccess($user, 'NotExistingKey', 'READ');
    }

    /** @dataProvider providerAccessDeniedForNotConfiguredAttributeInEntry */
    public function testAccessDeniedForNotConfiguredAttributeInEntry(User $user, string $attribute): void
    {
        $accessResolver = AccessResolverMother::create();

        $hasAccess = $accessResolver->hasAccess($user, DashboardAccessEntry::class, $attribute);

        $this->assertEquals(false, $hasAccess);
    }

    public function providerAccessDeniedForNotConfiguredAttributeInEntry(): array
    {
        return [
            //user, attribute
            [UserMother::withAclRoles([AclRoleMother::accessToDashboard()]), 'TEST'],
            [UserMother::withAclRoles([AclRoleMother::accessToDashboardWithFakeAttributeTEST()]), 'TEST'],
        ];
    }

    public function testTryingCheckAccessForIntegerKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $accessResolver = AccessResolverMother::create();
        $user = UserMother::withFullArticleAccess();

        $hasAccess = $accessResolver->hasAccess($user, 1, 'READ');
    }

    public function testInvalidAccessEntry(): void
    {
        $this->expectError();

        $accessResolver = AccessResolverMother::create();
        $accessList = AccessList::createFromRawArray([InvalidAccessEntry::key() => [InvalidAccessEntry::ACCESS]]);
        $user = UserMother::withAclRoles([(new AclRole())->setAccessList($accessList)]);

        $hasAccess = $accessResolver->hasAccess($user, InvalidAccessEntry::key() , InvalidAccessEntry::ACCESS);
    }

    public function testAccessForEntryWithOwnKey(): void
    {
        $accessResolver = AccessResolverMother::create();
        $user = UserMother::withAclRoles([AclRoleMother::accessToOwnKey()]);

        $hasAccess = $accessResolver->hasAccess($user, OwnKeyAccessEntry::key(), OwnKeyAccessEntry::ACCESS);

        $this->assertTrue($hasAccess);
    }
}