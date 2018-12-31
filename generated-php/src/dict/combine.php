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
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tk> $keys
 * @param iterable<mixed, Tv> $values
 *
 * @return array<Tk, Tv>
 */
function associate(iterable $keys, iterable $values)
{
    $keys = (array) $keys;
    $values = (array) $values;
    invariant(\count($keys) === \count($values), 'Expected length of keys and values to be the same');
    $result = [];
    foreach ($keys as $idx => $key) {
        $result[$key] = $values[$idx];
    }
    return $result;
}
/**
 * Merges multiple iterables into a new dict. In the case of duplicate
 * keys, later values will overwrite the previous ones.
 */
/**
 * @psalm-template Tk as \arraykey
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $first
 * @param iterable<Tk, Tv> $rest
 *
 * @return array<Tk, Tv>
 */
function merge(iterable $first, iterable ...$rest)
{
    $result = (array) $first;
    foreach ($rest as $traversable) {
        foreach ($traversable as $key => $value) {
            $result[$key] = $value;
        }
    }
    return $result;
}

