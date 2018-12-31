<?php

namespace {
	/**
	 * @param  mixed $condition
	 */
	function invariant(
	  $condition,
	  string ...$args
	): void {
		if (!$condition) {
			invariant_violation(...$args);
		}
	}

	/**
	 * @param  string $format_str
	 * @param  mixed $fmt_args
	 * @return no-return
	 */
	function invariant_violation(
	  string $format_str,
	  ...$fmt_args
	) {
		throw new \HH\InvariantException(printf($format_str, ...$fmt_args));
	}
}

namespace HH {
	class InvariantException extends \Exception  {}
}
