<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Keyset;

use HH\Lib\Math;
use HH\Lib\_Private\StubPHPism_FIXME as PHPism_FIXME;
use function HH\Lib\_Private\universal_chainable_stub as FBLogger;
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, array<Tv, Tv>>
 */
function chunk(iterable $traversable, int $size) : array
{
    invariant($size > 0, 'Expected positive chunk size, got %d.', $size);
    $result = [];
    $ii = 0;
    foreach ($traversable as $value) {
        if ($ii % $size === 0) {
            $result[] = [];
        }
        $result[Math\int_div($ii, $size)][] = $value;
        $ii++;
    }
    return $result;
}
/**
 * @psalm-template Tv1
 * @psalm-template Tv2 as \arraykey
 *
 * @param iterable<mixed, Tv1> $traversable
 * @param \Closure(Tv1):Tv2 $value_func
 *
 * @return array<Tv2, Tv2>
 */
function map(iterable $traversable, \Closure $value_func) : array
{
    $result = [];
    foreach ($traversable as $value) {
        $result[] = $value_func($value);
    }
    return $result;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv1
 * @psalm-template Tv2 as \arraykey
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tk, Tv1):Tv2 $value_func
 *
 * @return array<Tv2, Tv2>
 */
function map_with_key(iterable $traversable, \Closure $value_func) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[] = $value_func($key, $value);
    }
    return $result;
}
/**
 * Returns a new keyset formed by joining the values
 * within the given Traversables into
 * a keyset.
 *
 * For a fixed number of Traversables, see `Keyset\union()`.
 */
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, iterable<mixed, Tv>> $traversables
 *
 * @return array<Tv, Tv>
 */
function flatten(iterable $traversables) : array
{
    $result = [];
    foreach ($traversables as $traversable) {
        foreach ($traversable as $value) {
            $result[] = $value;
        }
    }
    return $result;
}

