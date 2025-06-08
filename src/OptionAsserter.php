<?php

namespace Wulfheart\Option;

use PHPUnit\Framework\Assert;

final class OptionAsserter
{
    /**
     * @param Option<mixed> $o
     */
    public static function assertSome(Option $o): void
    {
        Assert::assertTrue($o->isSome());
    }
}
