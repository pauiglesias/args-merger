<?php

namespace PauIglesias\ArgsMerger;

use Illuminate\Support\Facades\Facade;

/**
 * Main Class facade
 */
class Merger extends Facade {
	protected static function getFacadeAccessor() {
		return ArgsMerger::class;
	}
}