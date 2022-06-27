<?php

declare(strict_types=1);

namespace Xazoom\AclSystem;

use Xazoom\AclSystem\AccessEntry\Exception\KeyAccessEntryNotRecognisedException;
use Xazoom\AclSystem\AccessResolver\AccessResolverInterface;
use Xazoom\AclSystem\Entity\AclIdentity;

class Acl implements AclInterface
{
    private AccessResolverInterface $accessResolver;

    public function __construct(AccessResolverInterface $accessResolver)
    {
        $this->accessResolver = $accessResolver;
    }

    /**
     * @param mixed $resource
     *
     * @throws KeyAccessEntryNotRecognisedException
     */
    public function hasAccess(?AclIdentity $aclIdentity, $resource, string $attribute): bool
    {
        if (null === $aclIdentity) {
            return false;
        }

        return $this->accessResolver->hasAccess($aclIdentity, $resource, $attribute);
    }
}
