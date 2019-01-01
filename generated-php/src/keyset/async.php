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

use HH\Lib\Vec;
/**
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, \Sabre\Event\Promise<Tv>> $awaitables
 *
 * @return \Sabre\Event\Promise<array<Tv, Tv>>
 */
function from_async(iterable $awaitables) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tv, Tv>> */
        function () use($awaitables) : \Generator {
            $vec = (yield Vec\from_async($awaitables));
            return (array) $vec;
        }
    );
}
/**
 * @psalm-template Tv as \arraykey
 *
 * @param Container<Tv> $traversable
 * @param \Closure(Tv):\Sabre\Event\Promise<bool> $value_predicate
 *
 * @return \Sabre\Event\Promise<array<Tv, Tv>>
 */
function filter_async(Container $traversable, \Closure $value_predicate) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tv, Tv>> */
        function () use($traversable, $value_predicate) : \Generator {
            $tests = (yield Vec\map_async($traversable, $value_predicate));
            $result = [];
            $ii = 0;
            foreach ($traversable as $value) {
                if ($tests[$ii]) {
                    $result[] = $value;
                }
                $ii++;
            }
            return $result;
        }
    );
}
/**
 * @psalm-template Tv
 * @psalm-template Tk as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):\Sabre\Event\Promise<Tk> $async_func
 *
 * @return \Sabre\Event\Promise<array<Tk, Tk>>
 */
function map_async(iterable $traversable, \Closure $async_func) : \Sabre\Event\Promise
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<Tk, Tk>> */
        function () use($traversable, $async_func) : \Generator {
            $vec = (yield Vec\map_async($traversable, $async_func));
            return (array) $vec;
        }
    );
}

