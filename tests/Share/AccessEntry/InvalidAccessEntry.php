<?php

namespace Xazoom\AclSystem\Tests\Share\AccessEntry;

use Xazoom\AclSystem\AccessEntry\AbstractAccessEntry;

class InvalidAccessEntry extends AbstractAccessEntry
{
    public const ACCESS = 'access';

    protected function getAttributes(): array
    {
        return [
            self::ACCESS => [$this, 'hasAccess'],
        ];
    }
}