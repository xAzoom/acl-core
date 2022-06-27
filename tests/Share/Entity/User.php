<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Tests\Share\Entity;

use Webmozart\Assert\Assert;
use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\Entity\AclRole;

class User implements AclIdentity
{
    private array $aclRoles = [];

    public function __construct(array $aclRoles)
    {
        Assert::allIsInstanceOf($aclRoles, AclRole::class);
        $this->aclRoles = $aclRoles;
    }

    public function getAclRoles(): array
    {
        return $this->aclRoles;
    }
}
