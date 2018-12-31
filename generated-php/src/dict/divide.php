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
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 * @param \Closure(Tv):bool $predicate
 *
 * @return array{0:array<Tk, Tv>, 1:array<Tk, Tv>}
 */
function partition(KeyedTraversable $traversable, \Closure $predicate)
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
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param KeyedTraversable<Tk, Tv> $traversable
 * @param \Closure(Tk, Tv):bool $predicate
 *
 * @return array{0:array<Tk, Tv>, 1:array<Tk, Tv>}
 */
function partition_with_key(KeyedTraversable $traversable, \Closure $predicate)
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

