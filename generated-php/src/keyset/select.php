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

/**
 * Returns a new keyset containing only the elements of the first Traversable
 * that do not appear in any of the other ones.
 */
/**
 * @template Tv1 as array-key
 * @template Tv2 as array-key
 *
 * @param iterable<mixed, Tv1> $first
 * @param iterable<mixed, Tv2> $second
 * @param iterable<mixed, Tv2> ...$rest
 *
 * @return array<Tv1, Tv1>
 */
function diff(iterable $first, iterable $second, iterable ...$rest) : array
{
    if (!$first) {
        return [];
    }
    if (!$second && !$rest) {
        return (array) $first;
    }
    $union = !$rest ? (array) $second : union($second, ...$rest);
    return filter($first, function ($value) use($union) {
        return !\array_key_exists($value, $union);
    });
}
/**
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<Tv, Tv>
 */
function drop(iterable $traversable, int $n) : array
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
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $traversable
 * @param null|\Closure(Tv):bool $value_predicate
 *
 * @return array<Tv, Tv>
 */
function filter(iterable $traversable, ?\Closure $value_predicate = null) : array
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
 * @template Tv as array-key
 *
 * @param iterable<mixed, null|Tv> $traversable
 *
 * @return array<Tv, Tv>
 */
function filter_nulls(iterable $traversable) : array
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
 * @template Tk
 * @template Tv as array-key
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array<Tv, Tv>
 */
function filter_with_key(iterable $traversable, \Closure $predicate) : array
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
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<Tk, Tk>
 */
function keys(iterable $traversable) : array
{
    $result = [];
    foreach ($traversable as $key => $_) {
        $result[] = $key;
    }
    return $result;
}
/**
 * Returns a new keyset containing only the elements of the first Traversable
 * that appear in all the other ones.
 */
/**
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $second
 * @param iterable<mixed, Tv> ...$rest
 *
 * @return array<Tv, Tv>
 */
function intersect(iterable $first, iterable $second, iterable ...$rest) : array
{
    if (!$second && !$rest) {
        return [];
    }
    $intersection = (array) $first;
    $rest[] = $second;
    foreach ($rest as $traversable) {
        $next_intersection = [];
        foreach ($traversable as $value) {
            if (\array_key_exists($value, $intersection)) {
                $next_intersection[] = $value;
            }
        }
        $intersection = $next_intersection;
    }
    return $intersection;
}
/**
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<Tv, Tv>
 */
function take(iterable $traversable, int $n) : array
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

