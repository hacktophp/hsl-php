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

use HH\Lib\C;
/**
 * @template Tv as array-key
 *
 * @param array<Tv, Tv> $keyset1
 * @param array<Tv, Tv> $keyset2
 */
function equal(array $keyset1, array $keyset2) : bool
{
    return $keyset1 == $keyset2;
}

