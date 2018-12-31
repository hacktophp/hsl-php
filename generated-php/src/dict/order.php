<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Dict;

use HH\Lib\Vec;
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 *
 * @return array<Tk, Tv>
 */
function reverse(KeyedTraversable $traversable)
{
    $dict = (array) $traversable;
    return from_keys(Vec\reverse(Vec\keys($dict)), function ($k) use($dict) {
        return $dict[$k];
    });
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 * @param null|\Closure(Tv, Tv):int $value_comparator
 *
 * @return array<Tk, Tv>
 */
function sort(KeyedTraversable $traversable, ?\Closure $value_comparator = null)
{
    $result = (array) $traversable;
    if ($value_comparator) {
        \uasort($result, $value_comparator);
    } else {
        \asort($result);
    }
    return $result;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 * @psalm-template Ts
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 * @param \Closure(Tv):Ts $scalar_func
 * @param null|\Closure(Ts, Ts):int $scalar_comparator
 *
 * @return array<Tk, Tv>
 */
function sort_by(KeyedTraversable $traversable, \Closure $scalar_func, ?\Closure $scalar_comparator = null)
{
    $tuple_comparator = $scalar_comparator ? function ($a, $b) use($scalar_comparator) {
        return $scalar_comparator($a[0], $b[0]);
    } : function ($a, $b) {
        return $a[0] <=> $b[0];
    };
    return map(sort(map($traversable, function ($v) use($scalar_func) {
        return [$scalar_func($v), $v];
    }), $tuple_comparator), function ($t) {
        return $t[1];
    });
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 * @param null|\Closure(Tk, Tk):int $key_comparator
 *
 * @return array<Tk, Tv>
 */
function sort_by_key(KeyedTraversable $traversable, ?\Closure $key_comparator = null)
{
    $result = (array) $traversable;
    if ($key_comparator) {
        \uksort($result, $key_comparator);
    } else {
        \ksort($result);
    }
    return $result;
}

