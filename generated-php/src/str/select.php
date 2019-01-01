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

use HH\Lib\_Private;
function slice(string $string, int $offset, ?int $length = null) : string
{
    invariant($length === null || $length >= 0, 'Expected non-negative length.');
    $offset = _Private\validate_offset($offset, length($string));
    $result = $length === null ? \substr($string, $offset) : \substr($string, $offset, $length);
    if ($result === false) {
        return '';
    }
    return $result;
}
function strip_prefix(string $string, string $prefix) : string
{
    if ($prefix === '' || !starts_with($string, $prefix)) {
        return $string;
    }
    return slice($string, length($prefix));
}
function strip_suffix(string $string, string $suffix) : string
{
    if ($suffix === '' || !ends_with($string, $suffix)) {
        return $string;
    }
    return slice($string, 0, length($string) - length($suffix));
}
function trim(string $string, ?string $char_mask = null) : string
{
    return $char_mask === null ? \trim($string) : \trim($string, $char_mask);
}
function trim_left(string $string, ?string $char_mask = null) : string
{
    return $char_mask === null ? \ltrim($string) : \ltrim($string, $char_mask);
}
function trim_right(string $string, ?string $char_mask = null) : string
{
    return $char_mask === null ? \rtrim($string) : \rtrim($string, $char_mask);
}

