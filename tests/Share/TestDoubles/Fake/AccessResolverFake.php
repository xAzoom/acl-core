<?php

declare(strict_types=1);

namespace Xazoom\AclSystem\Tests\Share\TestDoubles\Fake;

use Webmozart\Assert\Assert;
use Xazoom\AclSystem\Entity\AclIdentity;
use Xazoom\AclSystem\AccessResolver\AccessResolverInterface;

class AccessResolverFake implements AccessResolverInterface
{
    private array $returns;

    public array $logs = [];

    public function __construct(array $returns)
    {
        Assert::allBoolean($returns);
        $this->returns = $returns;
    }

    public function hasAccess(AclIdentity $aclIdentity, $resource, string $attribute): bool
    {
        if (empty($this->returns)) {
            throw new \RuntimeException('Return not configured before access');
        }

        $this->logs[] = [
            'identity' => $aclIdentity,
            'resource' => $resource,
            'attribute' => $attribute,
        ];

        return array_shift($this->returns);
    }
}
