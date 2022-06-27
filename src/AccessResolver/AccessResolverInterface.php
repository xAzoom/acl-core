<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\AccessResolver;

use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;
use Xazoom\AclSystem\Entity\AclIdentity;

interface AccessResolverInterface
{
    /**
     * @param mixed $resource
     *
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool;
}
