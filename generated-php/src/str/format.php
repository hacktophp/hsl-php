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
 * This interface describes features of a valid format string for `Str\format`
 */
interface SprintfFormat
{
    /**
     * @return string
     */
    public function format_d(int $s);
    /**
     * @return string
     */
    public function format_s(string $s);
    /**
     * @return string
     */
    public function format_u(int $s);
    /**
     * @return string
     */
    public function format_b(int $s);
    // Technically %f is locale-dependent (and thus wrong)
    /**
     * @return string
     */
    public function format_f(float $s);
    /**
     * @return string
     */
    public function format_g(float $s);
    /**
     * @return string
     */
    public function format_upcase_f(float $s);
    /**
     * @return string
     */
    public function format_e(float $s);
    /**
     * @return string
     */
    public function format_upcase_e(float $s);
    /**
     * @return string
     */
    public function format_x(int $s);
    /**
     * @return string
     */
    public function format_o(int $s);
    /**
     * @return string
     */
    public function format_c(int $s);
    /**
     * @return string
     */
    public function format_upcase_x(int $s);
    // %% takes no arguments
    /**
     * @return string
     */
    public function format_0x25();
    // Modifiers that don't change the type
    /**
     * @return SprintfFormat
     */
    public function format_l();
    /**
     * @return SprintfFormat
     */
    public function format_0x20();
    /**
     * @return SprintfFormat
     */
    public function format_0x2b();
    /**
     * @return SprintfFormat
     */
    public function format_0x2d();
    /**
     * @return SprintfFormat
     */
    public function format_0x2e();
    /**
     * @return SprintfFormat
     */
    public function format_0x30();
    /**
     * @return SprintfFormat
     */
    public function format_0x31();
    /**
     * @return SprintfFormat
     */
    public function format_0x32();
    /**
     * @return SprintfFormat
     */
    public function format_0x33();
    /**
     * @return SprintfFormat
     */
    public function format_0x34();
    /**
     * @return SprintfFormat
     */
    public function format_0x35();
    /**
     * @return SprintfFormat
     */
    public function format_0x36();
    /**
     * @return SprintfFormat
     */
    public function format_0x37();
    /**
     * @return SprintfFormat
     */
    public function format_0x38();
    /**
     * @return SprintfFormat
     */
    public function format_0x39();
    /**
     * @return SprintfFormatQuote
     */
    public function format_0x27();
}
/**
 * Accessory interface for `SprintfFormat`
 * Note: This should really be a wildcard. It's only used once (with '=').
 */
interface SprintfFormatQuote
{
    /**
     * @return SprintfFormat
     */
    public function format_0x3d();
}

/**
 * @param \HH\FormatString<SprintfFormat> $format_string
 * @param mixed ...$format_args
 */
function format(\HH\FormatString $format_string, ...$format_args) : string
{
    return \vsprintf($format_string, $format_args);
}

