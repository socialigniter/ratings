<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Ratings : Routes
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	URI Routes for Ratings for Social Igniter 
*/
$route['ratings'] 						= 'ratings';
$route['ratings/vote_up_down/(:any)']	= 'ratings/vote_up_down/$1';
$route['ratings/vote']					= 'ratings/index';