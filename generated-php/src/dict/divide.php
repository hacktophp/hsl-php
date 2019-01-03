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
 * @template Tk as \arraykey
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tv):bool $predicate
 *
 * @return array{0:array<Tk, Tv>, 1:array<Tk, Tv>}
 */
function partition(iterable $traversable, \Closure $predicate) : array
{
    $success = [];
    $failure = [];
    foreach ($traversable as $key => $value) {
        if ($predicate($value)) {
            $success[$key] = $value;
        } else {
            $failure[$key] = $value;
        }
    }
    return [$success, $failure];
}
/**
 * @template Tk as \arraykey
 * @template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array{0:array<Tk, Tv>, 1:array<Tk, Tv>}
 */
function partition_with_key(iterable $traversable, \Closure $predicate) : array
{
    $success = [];
    $failure = [];
    foreach ($traversable as $key => $value) {
        if ($predicate($key, $value)) {
            $success[$key] = $value;
        } else {
            $failure[$key] = $value;
        }
    }
    return [$success, $failure];
}

