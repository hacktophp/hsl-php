<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
/**
 * C is for Containers. This file contains functions that ask
 * questions of (i.e. introspect) containers and traversables.
 */
namespace HH\Lib\C;

/**
 * @template T
 *
 * @param iterable<mixed, T> $traversable
 * @param null|\Closure(T):bool $predicate
 */
function any(iterable $traversable, ?\Closure $predicate = null) : bool
{
    $predicate = $predicate ?? fun('\\HH\\Lib\\_Private\\boolval');
    foreach ($traversable as $value) {
        if ($predicate($value)) {
            return true;
        }
    }
    return false;
}
/**
 * @template T
 *
 * @param iterable<mixed, T> $traversable
 * @param T $value
 */
function contains(iterable $traversable, $value) : bool
{
    if (\is_array($traversable)) {
        return contains_key($traversable, $value);
    }
    foreach ($traversable as $v) {
        if ($value === $v) {
            return true;
        }
    }
    return false;
}
/**
 * @template Tk
 * @template Tv
 *
 * @param iterable<Tk, Tv> $container
 * @param Tk $key
 */
function contains_key(iterable $container, $key) : bool
{
    return \array_key_exists($key, $container);
}
/**
 * @template T
 *
 * @param iterable<mixed, T> $container
 */
function count(iterable $container) : int
{
    return \count($container);
}
/**
 * @template T
 *
 * @param iterable<mixed, T> $traversable
 * @param null|\Closure(T):bool $predicate
 */
function every(iterable $traversable, ?\Closure $predicate = null) : bool
{
    $predicate = $predicate ?? fun('\\HH\\Lib\\_Private\\boolval');
    foreach ($traversable as $value) {
        if (!$predicate($value)) {
            return false;
        }
    }
    return true;
}
/**
 * @template T
 *
 * @param iterable<mixed, T> $container
 */
function is_empty(iterable $container) : bool
{
    return !$container;
}

