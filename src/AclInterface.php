<?php

declare(strict_types=1);

namespace Xazoom\AclSystem;

use Xazoom\AclSystem\Entity\AclIdentity;

interface AclInterface
{
    /** @param object|string $resource */
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool;
}
