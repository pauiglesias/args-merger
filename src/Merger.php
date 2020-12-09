<?php

// Package namespace
namespace PauIglesias\ArgsMerger;

// Dependencies
use Illuminate\Support\Facades\Facade;

/**
 * Facade class
 */
class Merger extends Facade {
	protected static function getFacadeAccessor() {
		return ArgsMerger::class;
	}
}