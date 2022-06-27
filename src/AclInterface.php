<?php

declare(strict_types=1);

namespace Xazoom\AclSystem;

use Xazoom\AclSystem\Entity\AclIdentity;

interface AclInterface
{
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool;
}
