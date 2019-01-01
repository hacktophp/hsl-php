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

use HH\Lib\{C, Dict, Math, Str};
/**
 * @psalm-template Tv as numeric
 *
 * @param Tv $start
 * @param Tv $end
 * @param null|Tv $step
 *
 * @return array<int, Tv>
 */
function range($start, $end, $step = null) : array
{
    $step = $step ?? 1;
    invariant($step > 0, 'Expected positive step.');
    if ($step > Math\abs($end - $start)) {
        return [$start];
    }
    return (array) \range($start, $end, $step);
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function reverse(iterable $traversable) : array
{
    $vec = (array) $traversable;
    $lo = 0;
    $hi = \count($vec) - 1;
    while ($lo < $hi) {
        $temp = $vec[$lo];
        $vec[$lo++] = $vec[$hi];
        $vec[$hi--] = $temp;
    }
    return $vec;
}
/**
 * Returns a new vec with the values of the given Traversable in a random
 * order.
 */
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function shuffle(iterable $traversable) : array
{
    $vec = (array) $traversable;
    \shuffle($vec);
    return $vec;
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 * @param null|\Closure(Tv, Tv):int $comparator
 *
 * @return array<int, Tv>
 */
function sort(iterable $traversable, ?\Closure $comparator = null) : array
{
    $vec = (array) $traversable;
    if ($comparator) {
        \usort($vec, $comparator);
    } else {
        \sort($vec);
    }
    return $vec;
}
/**
 * @psalm-template Tv
 * @psalm-template Ts
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):Ts $scalar_func
 * @param null|\Closure(Ts, Ts):int $comparator
 *
 * @return array<int, Tv>
 */
function sort_by(iterable $traversable, \Closure $scalar_func, ?\Closure $comparator = null) : array
{
    $vec = (array) $traversable;
    $order_by = Dict\map($vec, $scalar_func);
    if ($comparator) {
        \uasort($order_by, $comparator);
    } else {
        \asort($order_by);
    }
    return map_with_key($order_by, function ($k, $v) use($vec) {
        return $vec[$k];
    });
}

