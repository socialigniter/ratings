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
		redirect();
	}

	function vote_up_down()
	{
		$vote_data = '';
		$javascript = $this->load->view('../modules/ratings/views/ratings/vote_up_down.js', $vote_data, TRUE);
		$this->output->set_content_type('text/javascript')->set_output($javascript);
	}

	/* Widgets */	
	function widgets_vote_up_down($widget_data)
	{
		$ratings		= $this->ratings_model->get_ratings($widget_data['object'], $widget_data['object_id']);
		$up_votes		= 0;
		$down_votes		= 0;
		$voter_ids		= array();
		$rating_view	= '';

		if ($ratings)
		{
			foreach ($ratings as $rating)
			{
				if ($rating->rating == 'up') $up_votes++;
				if ($rating->rating == 'down') $down_votes++;
				$voter_ids[$rating->user_id] = $rating->rating;
			}
		}

		$widget_data['up_votes']	= $up_votes;
		$widget_data['down_votes']	= $down_votes;
		$widget_data['voter_ids']	= json_encode($voter_ids);

		$this->load->view('widgets/vote_up_down', $widget_data);
	}

}
