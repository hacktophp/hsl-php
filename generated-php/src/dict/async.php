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

use HH\Lib\C;
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, \Sabre\Event\Promise<Tv>> $awaitables
 *
 * @return \Sabre\Event\Promise<array<Tk, Tv>>
 */
function from_async(iterable $awaitables) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tv>> */
        function () use($awaitables) : \Generator {
            $awaitables = (array) $awaitables;
            (yield AwaitAllWaitHandle::fromDict($awaitables));
            foreach ($awaitables as $key => $value) {
                $awaitables[$key] = \HH\Asio\result($value);
            }
            return $awaitables;
        }
    );
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tk> $keys
 * @param \Closure(Tk):\Sabre\Event\Promise<Tv> $async_func
 *
 * @return \Sabre\Event\Promise<array<Tk, Tv>>
 */
function from_keys_async(iterable $keys, \Closure $async_func) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tv>> */
        function () use($keys, $async_func) : \Generator {
            $awaitables = [];
            foreach ($keys as $key) {
                if (!C\contains_key($awaitables, $key)) {
                    $awaitables[$key] = $async_func($key);
                }
            }
            unset($keys);
            (yield AwaitAllWaitHandle::fromDict($awaitables));
            foreach ($awaitables as $key => $value) {
                $awaitables[$key] = \HH\Asio\result($value);
            }
            return $awaitables;
        }
    );
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedContainer<Tk, Tv> $traversable
 * @param \Closure(Tv):\Sabre\Event\Promise<bool> $value_predicate
 *
 * @return \Sabre\Event\Promise<array<Tk, Tv>>
 */
function filter_async(KeyedContainer $traversable, \Closure $value_predicate) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tv>> */
        function () use($traversable, $value_predicate) : \Generator {
            $tests = (yield map_async($traversable, $value_predicate));
            $result = [];
            foreach ($traversable as $key => $value) {
                if ($tests[$key]) {
                    $result[$key] = $value;
                }
            }
            return $result;
        }
    );
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedContainer<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):\Sabre\Event\Promise<bool> $predicate
 *
 * @return \Sabre\Event\Promise<array<Tk, Tv>>
 */
function filter_with_key_async(KeyedContainer $traversable, \Closure $predicate) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tv>> */
        function () use($traversable, $predicate) : \Generator {
            $tests = (yield from_async(map_with_key($traversable, function ($k, $v) use($predicate) {
                return (yield $predicate($k, $v));
            })));
            $result = [];
            foreach ($tests as $k => $v) {
                if ($v) {
                    $result[$k] = $traversable[$k];
                }
            }
            return $result;
        }
    );
}
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv1
 * @psalm-template Tv2
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tv1):\Sabre\Event\Promise<Tv2> $value_func
 *
 * @return \Sabre\Event\Promise<array<Tk, Tv2>>
 */
function map_async(iterable $traversable, \Closure $value_func) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tv2>> */
        function () use($traversable, $value_func) : \Generator {
            $traversable = (array) $traversable;
            foreach ($traversable as $key => $value) {
                $traversable[$key] = $value_func($value);
            }
            (yield AwaitAllWaitHandle::fromDict($traversable));
            foreach ($traversable as $key => $value) {
                $traversable[$key] = \HH\Asio\result($value);
            }
            return $traversable;
        }
    );
}

