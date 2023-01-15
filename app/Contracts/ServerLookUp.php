<?php

namespace App\Contracts;

/**
 * Simple interface to specify the concrete functions to implement within implementing classes.
 */
interface ServerLookUp
{
	public static function getName(): string;
    public static function getTestUser(): array;
    public function getUser($data);
    public function lookup($data);
}
