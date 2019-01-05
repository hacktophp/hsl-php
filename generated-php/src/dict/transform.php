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

use HH\Lib\Math;
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<int, array<Tk, Tv>>
 */
function chunk(iterable $traversable, int $size) : array
{
    invariant($size > 0, 'Expected positive chunk size, got %d.', $size);
    $result = [];
    $ii = 0;
    foreach ($traversable as $key => $value) {
        if ($ii % $size === 0) {
            $result[] = [];
        }
        $result[Math\int_div($ii, $size)][$key] = $value;
        $ii++;
    }
    return $result;
}
/**
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $values
 *
 * @return array<Tv, int>
 */
function count_values(iterable $values) : array
{
    $result = [];
    foreach ($values as $value) {
        $result[$value] = idx($result, $value, 0) + 1;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, \HH\Rx\KeyedTraversable<Tk, Tv>> $traversables
 *
 * @return array<Tk, Tv>
 */
function flatten(iterable $traversables) : array
{
    $result = [];
    foreach ($traversables as $traversable) {
        foreach ($traversable as $key => $value) {
            $result[$key] = $value;
        }
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, Tk> $keys
 * @param Tv $value
 *
 * @return array<Tk, Tv>
 */
function fill_keys(iterable $keys, $value) : array
{
    $result = [];
    foreach ($keys as $key) {
        $result[$key] = $value;
    }
    return $result;
}
/**
 * @template Tk
 * @template Tv as array-key
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return array<Tv, Tk>
 */
function flip(iterable $traversable) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[$value] = $key;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, Tk> $keys
 * @param \Closure(Tk):Tv $value_func
 *
 * @return array<Tk, Tv>
 */
function from_keys(iterable $keys, \Closure $value_func) : array
{
    $result = [];
    foreach ($keys as $key) {
        $result[$key] = $value_func($key);
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, array{0:Tk, 1:Tv}> $entries
 *
 * @return array<Tk, Tv>
 */
function from_entries(iterable $entries) : array
{
    $result = [];
    foreach ($entries as list($key, $value)) {
        $result[$key] = $value;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, Tv> $values
 * @param \Closure(Tv):Tk $key_func
 *
 * @return array<Tk, Tv>
 */
function from_values(iterable $values, \Closure $key_func) : array
{
    $result = [];
    foreach ($values as $value) {
        $result[$key_func($value)] = $value;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, Tv> $values
 * @param \Closure(Tv):(null|Tk) $key_func
 *
 * @return array<Tk, array<int, Tv>>
 */
function group_by(iterable $values, \Closure $key_func) : array
{
    $result = [];
    foreach ($values as $value) {
        $key = $key_func($value);
        if ($key === null) {
            continue;
        }
        if (!\array_key_exists($key, $result)) {
            $result[$key] = [];
        }
        $result[$key][] = $value;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tv1):Tv2 $value_func
 *
 * @return array<Tk, Tv2>
 */
function map(iterable $traversable, \Closure $value_func) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[$key] = $value_func($value);
    }
    return $result;
}
/**
 * @template Tk1
 * @template Tk2 as array-key
 * @template Tv
 *
 * @param iterable<Tk1, Tv> $traversable
 * @param \Closure(Tk1):Tk2 $key_func
 *
 * @return array<Tk2, Tv>
 */
function map_keys(iterable $traversable, \Closure $key_func) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[$key_func($key)] = $value;
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tk, Tv1):Tv2 $value_func
 *
 * @return array<Tk, Tv2>
 */
function map_with_key(iterable $traversable, \Closure $value_func) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[$key] = $value_func($key, $value);
    }
    return $result;
}
/**
 * @template Tk as array-key
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<mixed, Tv1> $traversable
 * @param \Closure(Tv1):Tv2 $value_func
 * @param \Closure(Tv1):Tk $key_func
 *
 * @return array<Tk, Tv2>
 */
function pull(iterable $traversable, \Closure $value_func, \Closure $key_func) : array
{
    $result = [];
    foreach ($traversable as $value) {
        $result[$key_func($value)] = $value_func($value);
    }
    return $result;
}
/**
 * @template Tk1
 * @template Tk2 as array-key
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<Tk1, Tv1> $traversable
 * @param \Closure(Tk1, Tv1):Tv2 $value_func
 * @param \Closure(Tk1, Tv1):Tk2 $key_func
 *
 * @return array<Tk2, Tv2>
 */
function pull_with_key(iterable $traversable, \Closure $value_func, \Closure $key_func) : array
{
    $result = [];
    foreach ($traversable as $key => $value) {
        $result[$key_func($key, $value)] = $value_func($key, $value);
    }
    return $result;
}

