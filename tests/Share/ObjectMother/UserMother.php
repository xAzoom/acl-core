<?php

namespace Xazoom\AclSystem\Tests\Share\ObjectMother;

use Xazoom\AclSystem\Tests\Share\Entity\User;

class UserMother
{
    public static function withFullArticleAccess(): User
    {
        return (new User([AclRoleMother::fullAccessToArticle()]));
    }

    public static function withReadArticleAccess(): User
    {
        return (new User([AclRoleMother::readAccessToArticle()]));
    }

    public static function withAclRoles(array $aclRoles): User
    {
        return new User($aclRoles);
    }
}