<?php

// Package namespace
namespace PauIglesias\ArgsMerger;

/**
 * Main package functionality
 */
trait ArgsMergerTrait {

	/**
	 * Safe merge by filtering/extending default existing keys
	 * See ArgsMerger class for details
	 *
	 * @return 	array 	Array of merged arguments
	 */
	protected function mergeArgs() {
		return app(ArgsMerger::class)->merge($defaultArgs, $inputArgs, $options);
	}
}