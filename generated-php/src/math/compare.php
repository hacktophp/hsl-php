<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Math;

/**
 * @psalm-template T as numeric
 *
 * @param T $first
 * @param T $second
 * @param T $rest
 *
 * @return T
 */
function maxva($first, $second, ...$rest)
{
    $max = $first > $second ? $first : $second;
    foreach ($rest as $number) {
        if ($number > $max) {
            $max = $number;
        }
    }
    return $max;
}
/**
 * @psalm-template T as numeric
 *
 * @param T $first
 * @param T $second
 * @param T $rest
 *
 * @return T
 */
function minva($first, $second, ...$rest)
{
    $min = $first < $second ? $first : $second;
    foreach ($rest as $number) {
        if ($number < $min) {
            $min = $number;
        }
    }
    return $min;
}

