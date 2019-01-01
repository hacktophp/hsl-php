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
 * Returns a new vec formed by concatenating the given Traversables together.
 *
 * For a variable number of Traversables, see `Vec\flatten()`.
 */
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $rest
 *
 * @return array<int, Tv>
 */
function concat(iterable $first, iterable ...$rest) : array
{
    $result = (array) $first;
    foreach ($rest as $traversable) {
        foreach ($traversable as $value) {
            $result[] = $value;
        }
    }
    return $result;
}

