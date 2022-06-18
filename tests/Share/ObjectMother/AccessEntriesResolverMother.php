<?php

namespace Xazoom\AclSystem\Tests\Share\ObjectMother;

use Xazoom\AclSystem\AccessEntry\AccessEntriesResolver;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\DashboardAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\InvalidAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\OwnKeyAccessEntry;

class AccessEntriesResolverMother
{
    public static function allAccessEntries(): AccessEntriesResolver
    {
        return new AccessEntriesResolver(
            [new ArticleAccessEntry(), new DashboardAccessEntry(), new InvalidAccessEntry(), new OwnKeyAccessEntry()]
        );
    }
}