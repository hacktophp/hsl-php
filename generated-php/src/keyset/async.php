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
 * @template Tv as array-key
 *
 * @param iterable<mixed, \Amp\Promise<Tv>> $awaitables
 *
 * @return \Amp\Promise<array<Tv, Tv>>
 */
function from_async(iterable $awaitables) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, array<Tv, Tv>> */
        function () use($awaitables) : \Generator {
            $vec = (yield Vec\from_async($awaitables));
            return (array) $vec;
        }
    );
}
/**
 * @template Tv as array-key
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):\Amp\Promise<bool> $value_predicate
 *
 * @return \Amp\Promise<array<Tv, Tv>>
 */
function filter_async(iterable $traversable, \Closure $value_predicate) : \Amp\Promise
{
    return \Amp\call(
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
 * @template Tv
 * @template Tk as array-key
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):\Amp\Promise<Tk> $async_func
 *
 * @return \Amp\Promise<array<Tk, Tk>>
 */
function map_async(iterable $traversable, \Closure $async_func) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, array<Tk, Tk>> */
        function () use($traversable, $async_func) : \Generator {
            $vec = (yield Vec\map_async($traversable, $async_func));
            return (array) $vec;
        }
    );
}

