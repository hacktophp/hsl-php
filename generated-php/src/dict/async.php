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
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<Tk, \Amp\Promise<Tv>> $awaitables
 *
 * @return \Amp\Promise<array<Tk, Tv>>
 */
function from_async(iterable $awaitables) : \Amp\Promise
{
    return \Amp\call(
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
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<mixed, Tk> $keys
 * @param \Closure(Tk):\Amp\Promise<Tv> $async_func
 *
 * @return \Amp\Promise<array<Tk, Tv>>
 */
function from_keys_async(iterable $keys, \Closure $async_func) : \Amp\Promise
{
    return \Amp\call(
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
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tv):\Amp\Promise<bool> $value_predicate
 *
 * @return \Amp\Promise<array<Tk, Tv>>
 */
function filter_async(iterable $traversable, \Closure $value_predicate) : \Amp\Promise
{
    return \Amp\call(
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
 * @template Tk as array-key
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):\Amp\Promise<bool> $predicate
 *
 * @return \Amp\Promise<array<Tk, Tv>>
 */
function filter_with_key_async(iterable $traversable, \Closure $predicate) : \Amp\Promise
{
    return \Amp\call(
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
 * @template Tk as array-key
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<Tk, Tv1> $traversable
 * @param \Closure(Tv1):\Amp\Promise<Tv2> $value_func
 *
 * @return \Amp\Promise<array<Tk, Tv2>>
 */
function map_async(iterable $traversable, \Closure $value_func) : \Amp\Promise
{
    return \Amp\call(
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

