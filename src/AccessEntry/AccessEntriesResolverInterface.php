<?php

namespace Xazoom\AclSystem\AccessEntry;

use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;

interface AccessEntriesResolverInterface
{
    /**
     * @param string|object $key
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function resolve($key): AbstractAccessEntry;
}