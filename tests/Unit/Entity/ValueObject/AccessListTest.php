<?php

namespace Xazoom\AclSystem\Tests\Unit\Entity\ValueObject;

use Xazoom\AclSystem\Entity\ValueObject\AccessList;
use Xazoom\AclSystem\Entity\ValueObject\Exception\KeyDoesNotExistsException;
use Xazoom\AclSystem\Tests\BaseTestCase;

class AccessListTest extends BaseTestCase
{
    public function testSuccessCreateEmptyAccessList(): void
    {
        $accessList = AccessList::createEmpty();

        $this->assertEmpty($accessList->getRawArrayAccessList());
    }

    public function testSuccessCreateAccessList(): void
    {
        $rawAccessList = ['key' => ['READ', 'EDIT', 'DELETE']];
        $accessList = AccessList::createFromRawArray($rawAccessList);

        $this->assertEquals($rawAccessList, $accessList->getRawArrayAccessList());
    }

    /** @dataProvider providerInvalidCreateFromRawArray */
    public function testInvalidCreateFromRawArray(array $data): void
    {
        $this->expectException(\InvalidArgumentException::class);

        AccessList::createFromRawArray($data);
    }

    public function providerInvalidCreateFromRawArray(): array
    {
        return [
            [['READ', 'WRITE']],
            [['key' => 'WRITE', 'READ']],
            [['key' => 1]],
        ];
    }

    public function testSuccessSetAccessEntry(): void
    {
        $accessList = AccessList::createEmpty();

        $result = $accessList->setAccessEntry('key', ['READ']);

        $this->assertEmpty($accessList->getRawArrayAccessList());
        $this->assertEquals(['key' => ['READ']], $result->getRawArrayAccessList());
    }

    public function testOverwriteAccessEntry(): void
    {
        $rawAccessList = ['key' => ['READ', 'EDIT', 'DELETE']];
        $accessList = AccessList::createFromRawArray($rawAccessList);

        $result = $accessList->setAccessEntry('key', ['READ']);

        $this->assertEquals($rawAccessList, $accessList->getRawArrayAccessList());
        $this->assertEquals(['key' => ['READ']], $result->getRawArrayAccessList());
    }

    public function testInvalidSetAccessEntry(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $accessList = AccessList::createEmpty();

        $result = $accessList->setAccessEntry('key', [1]);
    }

    /** @dataProvider providerMergeAccessLists */
    public function testMergeAccessLists(array $expected, array $lists): void
    {
        $accessLists = array_map(fn (array $rawAccessList) => AccessList::createFromRawArray($rawAccessList), $lists);

        $mergedAccessList = AccessList::merge($accessLists);

        $this->assertEquals($expected, $mergedAccessList->getRawArrayAccessList());
    }

    public function providerMergeAccessLists(): array
    {
        return [
            [
                ['key' => ['READ'], 'key2' => ['READ']],
                [['key' => ['READ']], ['key2' => ['READ']]]
            ],
            [
                ['key' => ['READ']],
                [['key' => ['READ']], ['key' => ['READ']]]
            ],
            [
                ['key' => ['READ', 'WRITE']],
                [['key' => ['READ']], ['key' => ['WRITE']]]
            ],
            [
                ['key' => ['READ', 'WRITE']],
                [['key' => ['READ']], ['key' => ['WRITE']], ['key' => ['READ']]]
            ],
        ];
    }

    public function testGetAttributes(): void
    {
        $rawAccessList = ['key' => ['READ', 'EDIT', 'DELETE']];
        $accessList = AccessList::createFromRawArray($rawAccessList);

        $attributes = $accessList->getAttributes('key');

        $this->assertEquals(['READ', 'EDIT', 'DELETE'], $attributes);
    }

    public function testGetAttributesForNotExistingKey(): void
    {
        $this->expectException(KeyDoesNotExistsException::class);

        $rawAccessList = ['key' => ['READ', 'EDIT', 'DELETE']];
        $accessList = AccessList::createFromRawArray($rawAccessList);

        $attributes = $accessList->getAttributes('key2');
    }
}