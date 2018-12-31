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

use HH\Lib\{Dict, Keyset};
/**
 * Returns a new vec containing only the elements of the first Traversable that
 * do not appear in any of the other ones.
 *
 * For vecs that contain non-arraykey elements, see `Vec\diff_by()`.
 */
/**
 * @psalm-template Tv1 as \arraykey
 * @psalm-template Tv2 as \arraykey
 *
 * @param iterable<mixed, Tv1> $first
 * @param iterable<mixed, Tv2> $second
 * @param iterable<mixed, Tv2> $rest
 *
 * @return array<int, Tv1>
 */
function diff(iterable $first, iterable $second, iterable ...$rest)
{
    if (!$first) {
        return [];
    }
    if (!$second && !$rest) {
        return (array) $first;
    }
    $union = !$rest ? (array) $second : Keyset\union($second, ...$rest);
    return filter($first, function ($value) use($union) {
        return !\array_key_exists($value, $union);
    });
}
/**
 * @psalm-template Tv
 * @psalm-template Ts as \arraykey
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $second
 * @param \Closure(Tv):Ts $scalar_func
 *
 * @return array<int, Tv>
 */
function diff_by(iterable $first, iterable $second, \Closure $scalar_func)
{
    if (!$first) {
        return [];
    }
    if (!$second) {
        return (array) $first;
    }
    $set = Keyset\map($second, $scalar_func);
    return filter($first, function ($value) use($scalar_func, $set) {
        return !\array_key_exists($scalar_func($value), $set);
    });
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function drop(iterable $traversable, int $n)
{
    invariant($n >= 0, 'Expected non-negative N, got %d.', $n);
    $result = [];
    $ii = -1;
    foreach ($traversable as $value) {
        $ii++;
        if ($ii < $n) {
            continue;
        }
        $result[] = $value;
    }
    return $result;
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 * @param null|\Closure(Tv):bool $value_predicate
 *
 * @return array<int, Tv>
 */
function filter(iterable $traversable, ?\Closure $value_predicate = null)
{
    $value_predicate = $value_predicate ?? fun('\\HH\\Lib\\_Private\\boolval');
    $result = [];
    foreach ($traversable as $value) {
        if ($value_predicate($value)) {
            $result[] = $value;
        }
    }
    return $result;
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, null|Tv> $traversable
 *
 * @return array<int, Tv>
 */
function filter_nulls(iterable $traversable)
{
    $result = [];
    foreach ($traversable as $value) {
        if ($value !== null) {
            $result[] = $value;
        }
    }
    return $result;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array<int, Tv>
 */
function filter_with_key(iterable $traversable, \Closure $predicate)
{
    $result = [];
    foreach ($traversable as $key => $value) {
        if ($predicate($key, $value)) {
            $result[] = $value;
        }
    }
    return $result;
}
/**
 * Returns a new vec containing only the elements of the first Traversable that
 * appear in all the other ones. Duplicate values are preserved.
 */
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $second
 * @param iterable<mixed, Tv> $rest
 *
 * @return array<int, Tv>
 */
function intersect(iterable $first, iterable $second, iterable ...$rest)
{
    $intersection = Keyset\intersect($first, $second, ...$rest);
    if (!$intersection) {
        return [];
    }
    return filter($first, function ($value) use($intersection) {
        return \array_key_exists($value, $intersection);
    });
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<int, Tk>
 */
function keys(iterable $traversable)
{
    $result = [];
    foreach ($traversable as $key => $_) {
        $result[] = $key;
    }
    return $result;
}
/**
 * Returns a new vec containing an unbiased random sample of up to
 * `$sample_size` elements (fewer iff `$sample_size` is larger than the size of
 * `$traversable`).
 */
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function sample(iterable $traversable, int $sample_size)
{
    invariant($sample_size >= 0, 'Expected non-negative sample size, got %d.', $sample_size);
    return take(shuffle($traversable), $sample_size);
}
/**
 * @psalm-template Tv
 *
 * @param Container<Tv> $container
 *
 * @return array<int, Tv>
 */
function slice(Container $container, int $offset, ?int $length = null)
{
    invariant($offset >= 0, 'Expected non-negative offset.');
    invariant($length === null || $length >= 0, 'Expected non-negative length.');
    return (array) \array_slice($container, $offset, $length);
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function take(iterable $traversable, int $n)
{
    if ($n === 0) {
        return [];
    }
    invariant($n > 0, 'Expected non-negative N, got %d.', $n);
    $result = [];
    $ii = 0;
    foreach ($traversable as $value) {
        $result[] = $value;
        $ii++;
        if ($ii === $n) {
            break;
        }
    }
    return $result;
}
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<int, Tv>
 */
function unique(iterable $traversable)
{
    return (array) (array) $traversable;
}
/**
 * @psalm-template Tv
 * @psalm-template Ts as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):Ts $scalar_func
 *
 * @return array<int, Tv>
 */
function unique_by(iterable $traversable, \Closure $scalar_func)
{
    return (array) Dict\from_values($traversable, $scalar_func);
}

