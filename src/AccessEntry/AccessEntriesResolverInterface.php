<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\AccessEntry;

use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;

interface AccessEntriesResolverInterface
{
    /**
     * @param object|string $key
     *
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function resolve($key): AbstractAccessEntry;
}
