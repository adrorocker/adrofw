<?php

/**
 * Database Adapter Interface
 *
 * @author Adro Rocker <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Db
 **/

namespace Adroframework\Db\Adapter;

Interface AdapterInterface
{
	/**
	 * Get configurtation to conect to DB
	 */
	public function getConfig();
}