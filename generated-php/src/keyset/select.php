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
 * @psalm-template Tv1 as \arraykey
 * @psalm-template Tv2 as \arraykey
 *
 * @param iterable<mixed, Tv1> $first
 * @param iterable<mixed, Tv2> $second
 * @param iterable<mixed, Tv2> $rest
 *
 * @return array<Tv1, Tv1>
 */
function diff(iterable $first, iterable $second, iterable ...$rest)
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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<Tv, Tv>
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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 * @param null|\Closure(Tv):bool $value_predicate
 *
 * @return array<Tv, Tv>
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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, null|Tv> $traversable
 *
 * @return array<Tv, Tv>
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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array<Tv, Tv>
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
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<Tk, Tk>
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
 * Returns a new keyset containing only the elements of the first Traversable
 * that appear in all the other ones.
 */
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $second
 * @param iterable<mixed, Tv> $rest
 *
 * @return array<Tv, Tv>
 */
function intersect(iterable $first, iterable $second, iterable ...$rest)
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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return array<Tv, Tv>
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

