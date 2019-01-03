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

/**
 * Returns a new keyset containing all of the elements of the given
 * Traversables.
 *
 * For a variable number of Traversables, see `Keyset\flatten()`.
 */
/**
 * @template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $first
 * @param iterable<mixed, Tv> $rest
 *
 * @return array<Tv, Tv>
 */
function union(iterable $first, iterable ...$rest) : array
{
    $result = (array) $first;
    foreach ($rest as $traversable) {
        foreach ($traversable as $value) {
            $result[] = $value;
        }
    }
    return $result;
}

