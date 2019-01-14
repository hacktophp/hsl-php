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

/**
 * @template Tv
 *
 * @param iterable<mixed, \Amp\Promise<Tv>> $awaitables
 *
 * @return \Amp\Promise<array<int, Tv>>
 */
function from_async(iterable $awaitables) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, array<int, Tv>> */
        function () use($awaitables) : \Generator {
            $awaitables = (array) $awaitables;
            (yield AwaitAllWaitHandle::fromVec($awaitables));
            foreach ($awaitables as $index => $value) {
                $awaitables[$index] = \HH\Asio\result($value);
            }
            return $awaitables;
        }
    );
}
/**
 * @template Tv
 *
 * @param iterable<mixed, Tv> $container
 * @param \Closure(Tv):\Amp\Promise<bool> $value_predicate
 *
 * @return \Amp\Promise<array<int, Tv>>
 */
function filter_async(iterable $container, \Closure $value_predicate) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, array<int, Tv>> */
        function () use($container, $value_predicate) : \Generator {
            $tests = (yield map_async($container, $value_predicate));
            $result = [];
            $ii = 0;
            foreach ($container as $value) {
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
 * @template Tv1
 * @template Tv2
 *
 * @param iterable<mixed, Tv1> $traversable
 * @param \Closure(Tv1):\Amp\Promise<Tv2> $async_func
 *
 * @return \Amp\Promise<array<int, Tv2>>
 */
function map_async(iterable $traversable, \Closure $async_func) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, array<int, Tv2>> */
        function () use($traversable, $async_func) : \Generator {
            $traversable = (array) $traversable;
            foreach ($traversable as $i => $value) {
                $traversable[$i] = $async_func($value);
            }
            (yield AwaitAllWaitHandle::fromVec($traversable));
            foreach ($traversable as $index => $value) {
                $traversable[$index] = \HH\Asio\result($value);
            }
            return $traversable;
        }
    );
}

