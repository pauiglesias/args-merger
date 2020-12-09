<?php

namespace PauIglesias\ArgsMerger;

/**
 * Simple trait method using the singleton instance
 */
trait ArgsMergerTrait {

	/**
	 * Safe merge by filtering/extending default existing keys
	 * See ArgsMerger class for details
	 *
	 * @return 	array 	Array of merged arguments
	 */
	protected function mergeArgs(array $defaultArgs, array $inputArgs, array $options = []) {
		return app(ArgsMerger::class)->merge($defaultArgs, $inputArgs, $options);
	}
}