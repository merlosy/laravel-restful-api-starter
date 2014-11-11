<?php

/**
 *	SmartLoquent class should be the parent class of all your model classes
 *	Based on your database choice, you will be using a Eloquent instance or MongoDB Eloquent one
 *	
 */
if ( Config::get('database.default')=='mongodb' ) {
	class SmartLoquent extends Moloquent{
		/**
		 *	Force Eloquent to use _id as PK and not id
		 */
		protected $primaryKey = '_id';
	}
}
else {
	class SmartLoquent extends Eloquent{
		/**
		 *	Force Eloquent to use _id as PK and not id
		 */
		protected $primaryKey = '_id';
	}
}
