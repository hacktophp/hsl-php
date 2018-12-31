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
 * C is for Containers. This file contains functions that run a calculation
 * over containers and traversables to get a single value result.
 */
namespace HH\Lib\C;

/**
 * @psalm-template Tv
 * @psalm-template Ta
 *
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Ta, Tv):Ta $accumulator
 * @param Ta $initial
 *
 * @return \Ta
 */
function reduce(iterable $traversable, \Closure $accumulator, $initial)
{
    $result = $initial;
    foreach ($traversable as $value) {
        $result = $accumulator($result, $value);
    }
    return $result;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 * @psalm-template Ta
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Ta, Tk, Tv):Ta $accumulator
 * @param Ta $initial
 *
 * @return \Ta
 */
function reduce_with_key(iterable $traversable, \Closure $accumulator, $initial)
{
    $result = $initial;
    foreach ($traversable as $key => $value) {
        $result = $accumulator($result, $key, $value);
    }
    return $result;
}

