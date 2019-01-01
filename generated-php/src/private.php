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

function validate_offset(int $offset, int $length) : int
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
 */
function is_any_array($val) : bool
{
    return \is_array($val) || \is_array($val) || \is_array($val) || \is_array($val);
}
/**
 * @param mixed $val
 */
function boolval($val) : bool
{
    return (bool) $val;
}
// Stub implementations of FB internals used to ease migrations
final class StubPHPism_FIXME
{
    /**
     * @psalm-template T
     *
     * @param iterable<mixed, T> $_0
     *
     * @return bool
     */
    public static function isForeachable(iterable $_0)
    {
        return true;
    }
}
final class UniversalChainableStub
{
    /**
     * @param mixed $_0
     * @param mixed $_1
     *
     * @return static
     */
    public function __call($_0, $_1)
    {
        return $this;
    }
}
/**
 * @param mixed $_0
 */
function universal_chainable_stub(...$_0) : UniversalChainableStub
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

