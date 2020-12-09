<?php

namespace PauIglesias\ArgsMerger;

use Illuminate\Support\ServiceProvider;

/**
 * Service Provider class
 */
class ArgsMergerServiceProvider extends ServiceProvider {

	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register() {
		$this->app->singleton(ArgsMerger::class, function () {
			return new ArgsMerger;
		});
	}
}