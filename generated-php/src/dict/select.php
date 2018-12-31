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

/**
 * Returns a new dict containing only the entries of the first iterable
 * whose keys do not appear in any of the other ones.
 */
/**
 * @psalm-template Tk1 as \arraykey
 * @psalm-template Tk2 as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk1, Tv> $first
 * @param iterable<Tk2, mixed> $second
 * @param iterable<Tk2, mixed> $rest
 *
 * @return array<Tk1, Tv>
 */
function diff_by_key(iterable $first, iterable $second, iterable ...$rest)
{
    if (!$first) {
        return [];
    }
    if (!$second && !$rest) {
        return (array) $first;
    }
    $union = merge($second, ...$rest);
    return filter_keys($first, function ($key) use($union) {
        return !\array_key_exists($key, $union);
    });
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<Tk, Tv>
 */
function drop(iterable $traversable, int $n)
{
    invariant($n >= 0, 'Expected non-negative N, got %d.', $n);
    $result = [];
    $ii = -1;
    foreach ($traversable as $key => $value) {
        $ii++;
        if ($ii < $n) {
            continue;
        }
        $result[$key] = $value;
    }
    return $result;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param null|\Closure(Tv):bool $value_predicate
 *
 * @return array<Tk, Tv>
 */
function filter(iterable $traversable, ?\Closure $value_predicate = null)
{
    $value_predicate = $value_predicate ?? fun('\\HH\\Lib\\_Private\\boolval');
    $dict = [];
    foreach ($traversable as $key => $value) {
        if ($value_predicate($value)) {
            $dict[$key] = $value;
        }
    }
    return $dict;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array<Tk, Tv>
 */
function filter_with_key(iterable $traversable, \Closure $predicate)
{
    $dict = [];
    foreach ($traversable as $key => $value) {
        if ($predicate($key, $value)) {
            $dict[$key] = $value;
        }
    }
    return $dict;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param null|\Closure(Tk):bool $key_predicate
 *
 * @return array<Tk, Tv>
 */
function filter_keys(iterable $traversable, ?\Closure $key_predicate = null)
{
    $key_predicate = $key_predicate ?? fun('\\HH\\Lib\\_Private\\boolval');
    $dict = [];
    foreach ($traversable as $key => $value) {
        if ($key_predicate($key)) {
            $dict[$key] = $value;
        }
    }
    return $dict;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, null|Tv> $traversable
 *
 * @return array<Tk, Tv>
 */
function filter_nulls(iterable $traversable)
{
    $result = [];
    foreach ($traversable as $key => $value) {
        if ($value !== null) {
            $result[$key] = $value;
        }
    }
    return $result;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedContainer<Tk, Tv> $container
 * @param iterable<mixed, Tk> $keys
 *
 * @return array<Tk, Tv>
 */
function select_keys(KeyedContainer $container, iterable $keys)
{
    $result = [];
    foreach ($keys as $key) {
        if (\array_key_exists($key, $container)) {
            $result[$key] = $container[$key];
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
 * @return array<Tk, Tv>
 */
function take(iterable $traversable, int $n)
{
    if ($n === 0) {
        return [];
    }
    invariant($n > 0, 'Expected non-negative length, got %d.', $n);
    $result = [];
    $ii = 0;
    foreach ($traversable as $key => $value) {
        $result[$key] = $value;
        $ii++;
        if ($ii === $n) {
            break;
        }
    }
    return $result;
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<Tk, Tv>
 */
function unique(iterable $traversable)
{
    return flip(flip($traversable));
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 * @psalm-template Ts as \arraykey
 *
 * @param KeyedContainer<Tk, Tv> $container
 * @param \Closure(Tv):Ts $scalar_func
 *
 * @return array<Tk, Tv>
 */
function unique_by(KeyedContainer $container, \Closure $scalar_func)
{
    // We first convert the container to dict[scalar_key => original_key] to
    // remove duplicates, then back to dict[original_key => original_value].
    return pull(pull_with_key($container, function ($k, $_) {
        return $k;
    }, function ($_, $v) use($scalar_func) {
        return $scalar_func($v);
    }), function ($orig_key) use($container) {
        return $container[$orig_key];
    }, function ($x) {
        return $x;
    });
}

