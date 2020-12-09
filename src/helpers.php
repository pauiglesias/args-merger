<?php

if (!function_exists('merge_args')) {

	/**
	 * Safe merge by filtering/extending default existing keys
	 * See ArgsMerger class for details
	 *
	 * @return 	array 	Array of merged arguments
	 */
	function merge_args(array $defaultArgs, array $inputArgs, array $options = []) {
		return app(PauIglesias\ArgsMerger\ArgsMerger::class)->merge($defaultArgs, $inputArgs, $options);
	}
}