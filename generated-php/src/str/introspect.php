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
function compare(string $string1, string $string2) : int
{
    return \strcmp($string1, $string2);
}
function compare_ci(string $string1, string $string2) : int
{
    return \strcasecmp($string1, $string2);
}
function contains(string $haystack, string $needle, int $offset = 0) : bool
{
    if ($needle === '') {
        _Private\validate_offset($offset, length($haystack));
        return true;
    }
    return search($haystack, $needle, $offset) !== null;
}
function contains_ci(string $haystack, string $needle, int $offset = 0) : bool
{
    if ($needle === '') {
        _Private\validate_offset($offset, length($haystack));
        return true;
    }
    return search_ci($haystack, $needle, $offset) !== null;
}
function ends_with(string $string, string $suffix) : bool
{
    $suffix_length = length($suffix);
    return $suffix_length === 0 || length($string) >= $suffix_length && \substr_compare($string, $suffix, -$suffix_length, $suffix_length) === 0;
}
function ends_with_ci(string $string, string $suffix) : bool
{
    $suffix_length = length($suffix);
    return $suffix_length === 0 || length($string) >= $suffix_length && \substr_compare($string, $suffix, -$suffix_length, $suffix_length, true) === 0;
}
function is_empty(?string $string) : bool
{
    return $string === null || $string === '';
}
function length(string $string) : int
{
    return \strlen($string);
}
function search(string $haystack, string $needle, int $offset = 0) : ?int
{
    $offset = _Private\validate_offset($offset, length($haystack));
    $position = \strpos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
function search_ci(string $haystack, string $needle, int $offset = 0) : ?int
{
    $offset = _Private\validate_offset($offset, length($haystack));
    $position = \stripos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
function search_last(string $haystack, string $needle, int $offset = 0) : ?int
{
    $haystack_length = length($haystack);
    invariant($offset >= -$haystack_length && $offset <= $haystack_length, 'Offset is out-of-bounds.');
    $position = \strrpos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
function starts_with(string $string, string $prefix) : bool
{
    return \strncmp($string, $prefix, length($prefix)) === 0;
}
function starts_with_ci(string $string, string $prefix) : bool
{
    return \strncasecmp($string, $prefix, length($prefix)) === 0;
}

