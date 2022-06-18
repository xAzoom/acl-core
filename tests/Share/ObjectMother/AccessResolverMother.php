<?php

namespace Xazoom\AclSystem\Tests\Share\ObjectMother;

use Xazoom\AclSystem\AccessResolver\AccessResolver;

class AccessResolverMother
{
    public static function create(): AccessResolver
    {
        return new AccessResolver(AccessEntriesResolverMother::allAccessEntries());
    }
}