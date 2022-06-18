<?php

namespace Xazoom\AclSystem\Entity;

interface AclIdentity
{
    /**
     * @return AclRole[]
     */
    public function getAclRoles(): array;
}