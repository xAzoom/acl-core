<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Entity\ValueObject;

use Webmozart\Assert\Assert;
use Xazoom\AclSystem\Entity\ValueObject\Exception\KeyDoesNotExistsException;

class AccessList
{
    /** @var array<string, string[]> */
    protected array $accessList;

    /** @param array<string, string[]> $accessesList */
    protected function __construct(array $accessesList)
    {
        $this->assertValidAccessList($accessesList);
        $this->accessList = $accessesList;
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    /** @param array<string, string[]> $accessesList */
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

    /** @return array<string, string[]> */
    public function getRawArrayAccessList(): array
    {
        return $this->accessList;
    }

    /**
     * @throws KeyDoesNotExistsException
     *
     * @return string[]
     */
    public function getAttributes(string $key): array
    {
        if (!$attributes = $this->accessList[$key] ?? null) {
            throw new KeyDoesNotExistsException(sprintf('Key %s does not exist', $key));
        }

        return $attributes;
    }

    /** @param string[] $attributes */
    public function setAccessEntry(string $key, array $attributes): self
    {
        Assert::allString($attributes);

        $accessesList = $this->accessList;
        $accessesList[$key] = $attributes;

        return self::createFromRawArray($accessesList);
    }

    /** @param  array<string, string[]> $accessList */
    protected function assertValidAccessList(array $accessList): void
    {
        Assert::isMap($accessList);

        foreach ($accessList as $accessEntry) {
            Assert::allString($accessEntry);
        }
    }
}
