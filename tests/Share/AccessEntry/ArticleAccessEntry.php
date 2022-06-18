<?php

namespace Xazoom\AclSystem\Tests\Share\AccessEntry;

use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessEntry\AbstractAccessEntry;
use Xazoom\AclSystem\Tests\Share\Entity\Article;

class ArticleAccessEntry extends AbstractAccessEntry
{
    public const READ = 'read';
    public const EDIT = 'edit';

    public const All = [self::READ, self::EDIT];

    public function resourceClass(): ?string
    {
        return Article::class;
    }

    protected function getAttributes(): array
    {
        return [
            self::READ => [$this, 'hasAccessToRead'],
            self::EDIT => [$this, 'hasAccessToEdit'],
        ];
    }

    public function hasAccessToRead(AclIdentity $aclIdentity, ?object $resource): bool
    {
        return true;
    }

    public function hasAccessToEdit(AclIdentity $aclIdentity, ?object $resource): bool
    {
        return true;
    }
}