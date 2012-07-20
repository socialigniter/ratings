<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Ratings : Install
* Author: 		Brennan Novak
* 		  		hi@brennannovak.com
* 
* Project:		http://social-igniter.com/
*
* Description: 	Installer values for Ratings for Social Igniter
*/

/* Settings */
$config['ratings_settings']['enabled']			= 'TRUE';
$config['ratings_settings']['widgets']			= 'TRUE';
$config['ratings_settings']['rate_type'] 		= 'TRUE';

/* Ratings Table */
$config['database_ratings_ratings_table'] = array(
	'rating_id' => array(
		'type' 					=> 'INT',
		'constraint' 			=> 32,
		'unsigned' 				=> TRUE,
		'auto_increment'		=> TRUE
	),
	'site_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 8,
		'null'					=> TRUE
	),
	'user_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'object' => array(
		'type'					=> 'CHAR',
		'constraint'			=> 32,
		'null'					=> TRUE
	),
	'object_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'type' => array(
		'type'					=> 'VARCHAR',
		'constraint'			=> 32,
		'null'					=> TRUE
	),
	'rating' => array(
		'type'					=> 'CHAR',
		'constraint'			=> 8,
		'null'					=> TRUE
	),
	'ip_address' => array(
		'type'					=> 'CHAR',
		'constraint'			=> 16,
		'null'					=> TRUE
	),
	'created_at' => array(
		'type'					=> 'DATETIME',
		'null'					=> TRUE
	),
	'updated_at' => array(
		'type'					=> 'DATETIME',
		'null'					=> TRUE
	)	
);
