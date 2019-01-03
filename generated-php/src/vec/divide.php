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
 * @param iterable<mixed, Tv> $traversable
 * @param \Closure(Tv):bool $predicate
 *
 * @return array{0:array<int, Tv>, 1:array<int, Tv>}
 */
function partition(iterable $traversable, \Closure $predicate) : array
{
    $success = [];
    $failure = [];
    foreach ($traversable as $value) {
        if ($predicate($value)) {
            $success[] = $value;
        } else {
            $failure[] = $value;
        }
    }
    return [$success, $failure];
}

