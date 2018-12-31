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
 * @psalm-template Tv as \arraykey
 *
 * @param iterable<mixed, Tv> $traversable
 * @param null|\Closure(Tv, Tv):int $comparator
 *
 * @return array<Tv, Tv>
 */
function sort(iterable $traversable, ?\Closure $comparator = null)
{
    $keyset = (array) $traversable;
    if ($comparator) {
        \uksort($keyset, $comparator);
    } else {
        \ksort($keyset);
    }
    return $keyset;
}

