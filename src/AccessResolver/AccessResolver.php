<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\AccessResolver;

use Xazoom\AclSystem\AccessEntry\AccessEntriesResolverInterface;
use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;
use Xazoom\AclSystem\AccessEntry\Exception\UnsupportedAttributeException;
use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\Entity\AclRole;
use Xazoom\AclSystem\Entity\ValueObject\AccessList;
use Xazoom\AclSystem\Entity\ValueObject\Exception\KeyDoesNotExistsException;

class AccessResolver implements AccessResolverInterface
{
    private AccessEntriesResolverInterface $accessEntriesResolver;

    public function __construct(AccessEntriesResolverInterface $accessEntriesResolver)
    {
        $this->accessEntriesResolver = $accessEntriesResolver;
    }

    /**
     * @param object|string $resource
     *
     * @throws KeyAccessEntryNotRecognisedException
     * @throws \InvalidArgumentException
     */
    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool
    {
        $accessesList = $this->resolveAccessListForRoles($aclIdentity->getAclRoles());
        $accessEntry = $this->accessEntriesResolver->resolve($resource);

        try {
            $attributesList = $accessesList->getAttributes($accessEntry::key());
        } catch (KeyDoesNotExistsException $e) {
            return false;
        }

        if (!\in_array($attribute, $attributesList, true)) {
            return false;
        }

        if (\is_string($resource)) {
            $resource = null;
        }

        try {
            return $accessEntry->resolveAccess($aclIdentity, $resource, $attribute);
        } catch (UnsupportedAttributeException $e) {
            return false;
        }
    }

    /**
     * @param AclRole[] $roles
     */
    private function resolveAccessListForRoles(array $roles): AccessList
    {
        $accessLists = array_map(fn (AclRole $aclRole) => $aclRole->getAccessList(), $roles);

        return AccessList::merge($accessLists);
    }
}
