<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Str;

/**
 * @return array<int, string>
 */
function chunk(string $string, int $chunk_size = 1)
{
    invariant($chunk_size >= 1, 'Expected positive chunk size.');
    return (array) \str_split($string, $chunk_size);
}
/**
 * @return array<int, string>
 */
function split(string $string, string $delimiter, ?int $limit = null)
{
    if ($delimiter === '') {
        if ($limit === null || $limit >= \strlen($string)) {
            return chunk($string);
        } else {
            if ($limit === 1) {
                return [$string];
            } else {
                invariant($limit > 1, 'Expected positive limit.');
                $result = chunk(\substr($string, 0, $limit - 1));
                $result[] = \substr($string, $limit - 1);
                return $result;
            }
        }
    } else {
        if ($limit === null) {
            return (array) \explode($delimiter, $string);
        } else {
            return (array) \explode($delimiter, $string, $limit);
        }
    }
}

