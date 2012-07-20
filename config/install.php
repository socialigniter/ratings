<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Ratings : Install
* Author: 		Localhost
* 		  		hi@brennannovak.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	Installer values for Ratings for Social Igniter 
*/

/* Settings */
$config['ratings_settings']['enabled']			= 'TRUE';
$config['ratings_settings']['create_permission'] 	= '3';
$config['ratings_settings']['publish_permission']	= '2';
$config['ratings_settings']['manage_permission']	= '2';


/* CUSTOM DATA */
/* FOR CONNECTIONS */
$config['ratings_settings']['consumer_key']	 	= '';
$config['ratings_settings']['consumer_secret'] 	= '';
$config['ratings_settings']['social_connection'] 	= 'TRUE';
$config['ratings_settings']['connections_redirect']= 'settings/connections/';

/* Sites */
$config['ratings_sites'][] = array(
	'url'		=> 'http://ratings.com/', 
	'module'	=> 'ratings',
	'type' 		=> 'remote', 
	'title'		=> 'Ratings', 
	'favicon'	=> 'http://ratings.com/favicon.ico'
);

/* Data Table */
$config['database_ratings_data_table'] = array(
'data_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> 11,
	'unsigned' 				=> TRUE,
	'auto_increment'		=> TRUE
),
'user_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> '11',
	'null'					=> TRUE
),
'text' => array(
	'type'					=> 'TEXT',
	'null'					=> TRUE
),
'created_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
),
'updated_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
));