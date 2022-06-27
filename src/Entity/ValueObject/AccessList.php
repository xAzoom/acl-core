<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Entity\ValueObject;

use Webmozart\Assert\Assert;
use Xazoom\AclSystem\Entity\ValueObject\Exception\KeyDoesNotExistsException;

class AccessList
{
    protected array $accessList;

    protected function __construct(array $accessesList)
    {
        $this->assertValidAccessList($accessesList);
        $this->accessList = $accessesList;
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public static function createFromRawArray(array $accessesList): self
    {
        return new self($accessesList);
    }

    /**
     * @param AccessList[] $accessesLists
     */
    public static function merge(array $accessesLists): self
    {
        $rawArrayAccessesLists = array_map(
            fn (AccessList $accessesList) => $accessesList->getRawArrayAccessList(),
            $accessesLists
        );

        $mergedLists = array_merge_recursive(...$rawArrayAccessesLists);

        $accessesListWithoutDuplications = array_map(
            fn (array $attributes) => array_values(array_unique($attributes)),
            $mergedLists
        );

        return self::createFromRawArray($accessesListWithoutDuplications);
    }

    public function getRawArrayAccessList(): array
    {
        return $this->accessList;
    }

    /**
     * @throws KeyDoesNotExistsException
     */
    public function getAttributes(string $key): array
    {
        if (!$attributes = $this->accessList[$key] ?? null) {
            throw new KeyDoesNotExistsException(sprintf('Key %s does not exist', $key));
        }

        return $attributes;
    }

    public function setAccessEntry(string $key, array $attributes): self
    {
        Assert::allString($attributes);

        $accessesList = $this->accessList;
        $accessesList[$key] = $attributes;

        return self::createFromRawArray($accessesList);
    }

    protected function assertValidAccessList(array $accessList): void
    {
        Assert::isMap($accessList);

        foreach ($accessList as $accessEntry) {
            Assert::allString($accessEntry);
        }
    }
}
