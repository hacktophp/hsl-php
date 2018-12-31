<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\_Private;

/**
 * @return int
 */
function validate_offset(int $offset, int $length)
{
    $original_offset = $offset;
    if ($offset < 0) {
        $offset += $length;
    }
    invariant($offset >= 0 && $offset <= $length, 'Offset (%d) was out-of-bounds.', $original_offset);
    return $offset;
}
/**
 * @param mixed $val
 *
 * @return bool
 */
function is_any_array($val)
{
    return \is_array($val) || \is_array($val) || \is_array($val) || \is_array($val);
}
/**
 * @param mixed $val
 *
 * @return bool
 */
function boolval($val)
{
    return (bool) $val;
}
// Stub implementations of FB internals used to ease migrations
final class StubPHPism_FIXME
{
    /**
     * @psalm-template T
     *
     * @param iterable<mixed, T> $_
     *
     * @return bool
     */
    public static function isForeachable(iterable $_)
    {
        return true;
    }
}
final class UniversalChainableStub
{
    /**
     * @param mixed $_
     * @param mixed $_
     *
     * @return static
     */
    public function __call($_0, $_0)
    {
        return $this;
    }
}
/**
 * @param mixed $_
 *
 * @return UniversalChainableStub
 */
function universal_chainable_stub(...$_)
{
    return new UniversalChainableStub();
}
/**
 * @param mixed $x
 *
 * @return mixed
 */
function tuple_from_vec($x)
{
    // @oss-disable: invariant_violation("Use varray instead.");
    return is_vec([1, 2]) ? $x : (array) $x;
}
/**
 * @var string
 */
const ALPHABET_ALPHANUMERIC = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

