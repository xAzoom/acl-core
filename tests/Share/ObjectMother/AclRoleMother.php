<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Tests\Share\ObjectMother;

use Xazoom\AclSystem\Entity\AclRole;
use Xazoom\AclSystem\Entity\ValueObject\AccessList;
use Xazoom\AclSystem\Tests\Share\AccessEntry\ArticleAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\DashboardAccessEntry;
use Xazoom\AclSystem\Tests\Share\AccessEntry\OwnKeyAccessEntry;

class AclRoleMother
{
    public static function fullAccessToArticle(): AclRole
    {
        return (new AclRole())
            ->setAccessList(AccessList::createFromRawArray([
                ArticleAccessEntry::key() => ArticleAccessEntry::All,
            ]))
        ;
    }

    public static function readAccessToArticle(): AclRole
    {
        return (new AclRole())
            ->setAccessList(AccessList::createFromRawArray([
                ArticleAccessEntry::key() => [ArticleAccessEntry::READ],
            ]))
        ;
    }

    public static function accessToDashboard(): AclRole
    {
        return (new AclRole())
            ->setAccessList(AccessList::createFromRawArray([
                DashboardAccessEntry::key() => [DashboardAccessEntry::ACCESS],
            ]))
        ;
    }

    public static function accessToDashboardWithFakeAttributeTEST(): AclRole
    {
        return (new AclRole())
            ->setAccessList(AccessList::createFromRawArray([
                DashboardAccessEntry::key() => [DashboardAccessEntry::ACCESS, 'TEST'],
            ]))
        ;
    }

    public static function accessToOwnKey(): AclRole
    {
        return (new AclRole())
            ->setAccessList(AccessList::createFromRawArray([
                OwnKeyAccessEntry::key() => [OwnKeyAccessEntry::ACCESS],
            ]))
        ;
    }
}
