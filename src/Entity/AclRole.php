<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Entity;

use Xazoom\AclSystem\Entity\ValueObject\AccessList;

class AclRole
{
    protected int $id;

    protected AccessList $accessList;

    public function __construct()
    {
        $this->accessList = AccessList::createEmpty();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setAccessList(AccessList $accessList): self
    {
        $this->accessList = $accessList;

        return $this;
    }

    public function getAccessList(): AccessList
    {
        return $this->accessList;
    }
}
