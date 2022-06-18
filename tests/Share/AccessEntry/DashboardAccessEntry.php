<?php

namespace Xazoom\AclSystem\Tests\Share\AccessEntry;

use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessEntry\AbstractAccessEntry;

class DashboardAccessEntry extends AbstractAccessEntry
{
    const ACCESS = 'access';

    protected function getAttributes(): array
    {
        return [
            self::ACCESS => [$this, 'hasAccess'],
        ];
    }

    public function hasAccess(AclIdentity $aclIdentity, ?object $resource): bool
    {
        return true;
    }
}