<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Vec;

use HH\Lib\Math;
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, array<int, Tv>>
 */
function chunk(iterable $traversable, int $size)
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
 * @psalm-template Tv
 *
 * @param Tv $value
 *
 * @return array<int, Tv>
 */
function fill(int $size, $value)
{
    invariant($size >= 0, 'Expected non-negative fill size, got %d.', $size);
    $result = [];
    for ($i = 0; $i < $size; $i++) {
        $result[] = $value;
    }
    return $result;
}
/**
 * Returns a new vec formed by joining the Traversable elements of the given
 * Traversable.
 *
 * For a fixed number of Traversables, see `Vec\concat()`.
 */
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, iterable<mixed, Tv>> $traversables
 *
 * @return array<int, Tv>
 */
function flatten(iterable $traversables)
{
    $result = [];
    foreach ($traversables as $traversable) {
        foreach ($traversable as $value) {
            $result[] = $value;
        }
    }
    return $result;
}
/**
 * @psalm-template Tv1
 * @psalm-template Tv2
 *
 * @param iterable<mixed, Tv1> $traversable
 * @param \Closure(Tv1):Tv2 $value_func
 *
 * @return array<int, Tv2>
 */
function map(iterable $traversable, \Closure $value_func)
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
 * @psalm-template Tv2
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tk, Tv1):Tv2 $value_func
 *
 * @return array<int, Tv2>
 */
function map_with_key(iterable $traversable, \Closure $value_func)
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[] = $value_func($key, $value);
    }
    return $result;
}

