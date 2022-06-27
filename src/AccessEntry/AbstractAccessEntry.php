<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\AccessEntry;

use Xazoom\AclSystem\AccessEntry\Exception\UnsupportedAttributeException;
use Xazoom\AclSystem\Entity\AclIdentity;

abstract class AbstractAccessEntry
{
    public static function key(): string
    {
        return static::class;
    }

    public function resourceClass(): ?string
    {
        return null;
    }

    /**
     * @throws UnsupportedAttributeException
     */
    public function resolveAccess(AclIdentity $aclIdentity, ?object $resource, string $attribute): bool
    {
        if (!$this->isSupportedAction($attribute)) {
            throw new UnsupportedAttributeException(
                sprintf('Attribute %s is not supported by %s access entry', $attribute, static::class)
            );
        }

        return \call_user_func($this->getAttributes()[$attribute], $aclIdentity, $resource);
    }

    abstract protected function getAttributes(): array;

    private function isSupportedAction(string $action): bool
    {
        return \in_array($action, $this->getSupportedAttributes(), true);
    }

    /** @return string[] */
    private function getSupportedAttributes(): array
    {
        return array_keys($this->getAttributes());
    }
}
