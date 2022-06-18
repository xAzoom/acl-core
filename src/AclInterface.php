<?php

namespace Xazoom\AclSystem;

use Xazoom\AclSystem\Entity\AclIdentity;

interface AclInterface
{
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool;
}