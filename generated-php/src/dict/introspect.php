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
 * @template Tk as \arraykey
 * @template Tv
 *
 * @param array<Tk, Tv> $dict1
 * @param array<Tk, Tv> $dict2
 */
function equal(array $dict1, array $dict2) : bool
{
    if ($dict1 === $dict2) {
        return true;
    }
    if (\count($dict1) !== \count($dict2)) {
        return false;
    }
    foreach ($dict1 as $key => $value) {
        if (!C\contains_key($dict2, $key) || $dict2[$key] !== $value) {
            return false;
        }
    }
    return true;
}

