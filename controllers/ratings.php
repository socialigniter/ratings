<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Ratings : Controller
* Author: 		Localhost
* 		  		hi@brennannovak.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the public Ratings Controller class
*/
class Ratings extends MY_Controller
{
    function __construct()
    {
        parent::__construct(); 
        
        $this->load->model('ratings/ratings_model');      
	}
	
	function index()
	{
		$this->data['page_title'] = 'Ratings';
		$this->render();
	}

	function vote_up_down() 
	{		
		$rating_data['json_votes'] = json_encode($this->ratings_model->get_ratings_view('object_id', $this->uri->segment(3)));
		

		$javascript = $this->load->view('../modules/ratings/views/ratings/vote_up_down', $rating_data, TRUE);
		$this->output->set_content_type('text/javascript')->set_output($javascript);
	}
	
	
}
