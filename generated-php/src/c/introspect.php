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
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 * @param null|\Closure(T):bool $predicate
 *
 * @return bool
 */
function any(iterable $traversable, ?\Closure $predicate = null)
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
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 * @param T $value
 *
 * @return bool
 */
function contains(iterable $traversable, $value)
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
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param KeyedContainer<Tk, Tv> $container
 * @param Tk $key
 *
 * @return bool
 */
function contains_key(KeyedContainer $container, $key)
{
    return \array_key_exists($key, $container);
}
/**
 * @psalm-template T
 *
 * @param Container<T> $container
 *
 * @return int
 */
function count(Container $container)
{
    return \count($container);
}
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 * @param null|\Closure(T):bool $predicate
 *
 * @return bool
 */
function every(iterable $traversable, ?\Closure $predicate = null)
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
 * @psalm-template T
 *
 * @param Container<T> $container
 *
 * @return bool
 */
function is_empty(Container $container)
{
    return !$container;
}

