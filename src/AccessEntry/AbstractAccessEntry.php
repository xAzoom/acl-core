<?php

namespace Xazoom\AclSystem\AccessEntry;

use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessEntry\Exception\UnsupportedAttributeException;

abstract class AbstractAccessEntry
{
    abstract protected function getAttributes(): array;

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
                sprintf('Attribute %s is not supported by %s access entry', $attribute, get_class($this))
            );
        }

        return call_user_func($this->getAttributes()[$attribute], $aclIdentity, $resource);
    }

    private function isSupportedAction(string $action): bool
    {
        return in_array($action, $this->getSupportedAttributes());
    }

    /** @return string[] */
    private function getSupportedAttributes(): array
    {
        return array_keys($this->getAttributes());
    }
}