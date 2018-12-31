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
 * @return string
 */
function capitalize(string $string)
{
    return \ucfirst($string);
}
/**
 * @return string
 */
function capitalize_words(string $string, string $delimiters = " \t\r\n\f\v")
{
    return \ucwords($string, $delimiters);
}
/**
 * @return string
 */
function format_number(\num $number, int $decimals = 0, string $decimal_point = '.', string $thousands_separator = ',')
{
    return \number_format($number, $decimals, $decimal_point, $thousands_separator);
}
/**
 * @return string
 */
function lowercase(string $string)
{
    return \strtolower($string);
}
/**
 * @return string
 */
function pad_left(string $string, int $total_length, string $pad_string = ' ')
{
    invariant($pad_string !== '', 'Expected non-empty pad string.');
    invariant($total_length >= 0, 'Expected non-negative total length.');
    return \str_pad($string, $total_length, $pad_string, \STR_PAD_LEFT);
}
/**
 * @return string
 */
function pad_right(string $string, int $total_length, string $pad_string = ' ')
{
    invariant($pad_string !== '', 'Expected non-empty pad string.');
    invariant($total_length >= 0, 'Expected non-negative total length.');
    return \str_pad($string, $total_length, $pad_string, \STR_PAD_RIGHT);
}
/**
 * @return string
 */
function repeat(string $string, int $multiplier)
{
    invariant($multiplier >= 0, 'Expected non-negative multiplier');
    return \str_repeat($string, $multiplier);
}
/**
 * @return string
 */
function replace(string $haystack, string $needle, string $replacement)
{
    return \str_replace($needle, $replacement, $haystack);
}
/**
 * @return string
 */
function replace_ci(string $haystack, string $needle, string $replacement)
{
    return \str_ireplace($needle, $replacement, $haystack);
}
/**
 * @param KeyedContainer<string, string> $replacements
 *
 * @return string
 */
function replace_every(string $haystack, KeyedContainer $replacements)
{
    return \str_replace(\array_keys($replacements), \array_values($replacements), $haystack);
}
/**
 * @return string
 */
function reverse(string $string)
{
    $lo = 0;
    $hi = namespace\length($string) - 1;
    while ($lo < $hi) {
        $temp = $string[$lo];
        $string[$lo++] = $string[$hi];
        $string[$hi--] = $temp;
    }
    return $string;
}
/**
 * @return string
 */
function splice(string $string, string $replacement, int $offset, ?int $length = null)
{
    invariant($length === null || $length >= 0, 'Expected non-negative length.');
    $offset = _Private\validate_offset($offset, length($string));
    return $length === null ? \substr_replace($string, $replacement, $offset) : \substr_replace($string, $replacement, $offset, $length);
}
/**
 * @return null|int
 */
function to_int(string $string)
{
    if ((string) (int) $string === $string) {
        return (int) $string;
    }
    return null;
}
/**
 * @return string
 */
function uppercase(string $string)
{
    return \strtoupper($string);
}

