<?php

namespace Xazoom\AclSystem\AccessEntry;

use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;

class AccessEntriesResolver implements AccessEntriesResolverInterface
{
    private array $accessEntryClassToAccessEntry;

    private array $entityClassToAccessEntry;

    /**
     * @param AbstractAccessEntry[] $accessEntries
     */
    public function __construct(array $accessEntries)
    {
        $this->build($accessEntries);
    }

    /**
     * @param string|object $key
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function resolve($key): AbstractAccessEntry
    {
        if (is_string($key)) {
            if ($accessEntry = $this->accessEntryClassToAccessEntry[$key] ?? null) {
                return $accessEntry;
            }

            if ($accessEntry = $this->entityClassToAccessEntry[$key] ?? null) {
                return $accessEntry;
            }

            throw new KeyAccessEntryNotRecognisedException(sprintf('Key %s not recognised', $key));
        }

        if (is_object($key)) {
            if ($accessEntry = $this->entityClassToAccessEntry[get_class($key)]) {
                return $accessEntry;
            }

            throw new KeyAccessEntryNotRecognisedException(sprintf('Key %s not recognised', get_class($key)));
        }

        throw new \InvalidArgumentException('resolve method support only string and objects');
    }

    /**
     * @param AbstractAccessEntry[] $accessEntries
     */
    private function build(array $accessEntries): void
    {
        foreach ($accessEntries as $accessEntry) {
            $this->accessEntryClassToAccessEntry[$accessEntry::key()] = $accessEntry;
            if ($accessEntry->resourceClass()) {
                $this->entityClassToAccessEntry[$accessEntry->resourceClass()] = $accessEntry;
            }
        }
    }
}