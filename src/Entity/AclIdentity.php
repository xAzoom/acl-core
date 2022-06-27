<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Entity;

interface AclIdentity
{
    /**
     * @return AclRole[]
     */
    public function getAclRoles(): array;
}
