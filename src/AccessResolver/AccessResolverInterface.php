<?php

namespace Xazoom\AclSystem\AccessResolver;

use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;

interface AccessResolverInterface
{
    /**
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool;
}