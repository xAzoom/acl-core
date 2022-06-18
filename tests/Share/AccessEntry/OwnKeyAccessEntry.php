<?php

namespace Xazoom\AclSystem\Tests\Share\AccessEntry;

use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessEntry\AbstractAccessEntry;

class OwnKeyAccessEntry extends AbstractAccessEntry
{
    public const ACCESS = 'access';

    public static function key(): string
    {
        return 'own_key';
    }

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