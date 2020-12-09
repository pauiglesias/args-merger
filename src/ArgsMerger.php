<?php

namespace PauIglesias\ArgsMerger;

/**
 * Main package class
 */
class ArgsMerger {



	/**
	 * Default options for merging.
	 * For security purposes, can only be modified by extending the main ArgsMerger class.
	 */
	protected $defaultOptions = [
		'overwrite' => true,	// Fill the default arguments with the corresponding values of input arguments.
		'recursive' => true,	// Merge recursively for arrays instead of direct value replacement.
		'extensible' => false, 	// Allow new keys from input arguments to extend the default ones.
	];



	/**
	 * Retrieve the current default options
	 *
	 * @return	array	The default options property
	 */
	public function defaultOptions() {
		return $this->defaultOptions;
	}



	/**
	 * Safe merge associative arrays optionally filtering by default on existing keys
	 * and performing deep array combination by recursion (according the options).
	 *
	 * @param 	array 	$defaultArgs	Associative array of expected or known arguments.
	 * @param 	array 	$inputArgs 		Associative array of unknown input arguments.
	 * @param	mixed	$options	A set of options with the desired merge behavior.
	 * @return 	array 	Final array of merged arguments
	 */
	public function merge(array $defaultArgs, array $inputArgs, array $options = []) {

		// Check input arguments
		if (empty($inputArgs)) {
			return $defaultArgs;
		}

		// Prepare options for merge methods
		$options = $this->mergeOptions($options);

		// Fill the default
		if ($options['overwrite']) {
			$defaultArgs = $this->mergeOverwriting($defaultArgs, $inputArgs, $options);
		}

		// Extend arguments
		if ($options['extensible']) {
			$defaultArgs = $this->mergeExtending($defaultArgs, $inputArgs);
		}

		// Done
		return $defaultArgs;
	}



	/**
	 * Prepare the current merge args options
	 *
	 * @param	array	$options	A set of options with the desired merge behavior.
	 * @return 	array 	Final options
	 */
	protected function mergeOptions(array $options) {

		// Recursion for options control
		static $inRecursionForOptions = false;

		// Initial options value
		if (empty($options)) {
			return $this->defaultOptions;
		}

		// Merge options only allowed on first call
		if ($inRecursionForOptions) {
			return $options;
		}

		// Merge options
		$inRecursionForOptions = true;
		$options = $this->merge($this->defaultOptions, $options, ['overwrite' => true, 'recursive' => false, 'extensible' => false]);
		$inRecursionForOptions = false;

		// Done
		return $options;
	}



	/**
	 * Fill the default arguments with existing keys on input arguments
	 *
	 * @param 	mixed 	$defaultArgs	Associative array of allowed arguments.
	 * @param 	mixed 	$inputArgs 		Associative array of unknown input arguments.
	 * @param	mixed	$options		A set of options with the desired merge behavior.
	 * @return 	array 	Final array of merged arguments
	 */
	protected function mergeOverwriting($defaultArgs, $inputArgs, $options) {

		// Extract input keys
		$inputKeys = array_keys($inputArgs);

		// Enum default keys
		foreach (array_keys($defaultArgs) as $defaultKey) {

			// Input needs this default key
			if (!in_array($defaultKey, $inputKeys)) {
				continue;
			}

			// Check recursive method
			if ($options['recursive'] &&
				$this->isAssociativeArray($defaultArgs[$defaultKey]) &&
				$this->isAssociativeArray($inputArgs[$defaultKey])) {
				$defaultArgs[$defaultKey] = $this->merge($defaultArgs[$defaultKey], $inputArgs[$defaultKey], $options);

			// Direct attribution
			} else {
				$defaultArgs[$defaultKey] = $inputArgs[$defaultKey];
			}
		}

		// Done
		return $defaultArgs;
	}



	/**
	 * Extend the default merged arguments with new keys and values.
	 *
	 * @param 	mixed 	$defaultArgs	Associative array of allowed arguments.
	 * @param 	mixed 	$inputArgs 		Associative array of unknown input arguments.
	 * @return 	array 	Final array as a result of extending default arguments
	 */
	protected function mergeExtending(array $defaultArgs, array $inputArgs) {
		foreach (array_diff(array_keys($inputArgs), array_keys($defaultArgs)) as $newKey) {
			$defaultArgs[$newKey] = $inputArgs[$newKey];
		}
		return $defaultArgs;
	}



	/**
	 * Check if a given value is an associative array
	 *
	 * @param 	mixed 	$value	Supposedly the array to be checked.
	 * @return 	bool 	Wether is an array associative or not (empty or non array values return false).
	 */
	public function isAssociativeArray($value) {
		return (empty($value) || !is_array($value))
			? false
			: array_keys($value) !== range(0, count($value) - 1);
	}
}