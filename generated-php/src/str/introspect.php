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
/**
 * @return int
 */
function compare(string $string1, string $string2)
{
    return \strcmp($string1, $string2);
}
/**
 * @return int
 */
function compare_ci(string $string1, string $string2)
{
    return \strcasecmp($string1, $string2);
}
/**
 * @return bool
 */
function contains(string $haystack, string $needle, int $offset = 0)
{
    if ($needle === '') {
        _Private\validate_offset($offset, length($haystack));
        return true;
    }
    return search($haystack, $needle, $offset) !== null;
}
/**
 * @return bool
 */
function contains_ci(string $haystack, string $needle, int $offset = 0)
{
    if ($needle === '') {
        _Private\validate_offset($offset, length($haystack));
        return true;
    }
    return search_ci($haystack, $needle, $offset) !== null;
}
/**
 * @return bool
 */
function ends_with(string $string, string $suffix)
{
    $suffix_length = length($suffix);
    return $suffix_length === 0 || length($string) >= $suffix_length && \substr_compare($string, $suffix, -$suffix_length, $suffix_length) === 0;
}
/**
 * @return bool
 */
function ends_with_ci(string $string, string $suffix)
{
    $suffix_length = length($suffix);
    return $suffix_length === 0 || length($string) >= $suffix_length && \substr_compare($string, $suffix, -$suffix_length, $suffix_length, true) === 0;
}
/**
 * @return bool
 */
function is_empty(?string $string)
{
    return $string === null || $string === '';
}
/**
 * @return int
 */
function length(string $string)
{
    return \strlen($string);
}
/**
 * @return null|int
 */
function search(string $haystack, string $needle, int $offset = 0)
{
    $offset = _Private\validate_offset($offset, length($haystack));
    $position = \strpos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
/**
 * @return null|int
 */
function search_ci(string $haystack, string $needle, int $offset = 0)
{
    $offset = _Private\validate_offset($offset, length($haystack));
    $position = \stripos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
/**
 * @return null|int
 */
function search_last(string $haystack, string $needle, int $offset = 0)
{
    $haystack_length = length($haystack);
    invariant($offset >= -$haystack_length && $offset <= $haystack_length, 'Offset is out-of-bounds.');
    $position = \strrpos($haystack, $needle, $offset);
    if ($position === false) {
        return null;
    }
    return $position;
}
/**
 * @return bool
 */
function starts_with(string $string, string $prefix)
{
    return \strncmp($string, $prefix, length($prefix)) === 0;
}
/**
 * @return bool
 */
function starts_with_ci(string $string, string $prefix)
{
    return \strncasecmp($string, $prefix, length($prefix)) === 0;
}

