<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Ratings : API Controller
* Author: 		Localhost
* 		  		hi@brennannovak.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the Ratings API Controller class
*/
class Api extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('ratings_model');
	}

    /* Install App */
	function install_get()
	{
		// Load
		$this->load->library('installer');
		$this->load->config('install');
		$this->load->dbforge();

		// Create Data Table
		$this->dbforge->add_key('rating_id', TRUE);
		$this->dbforge->add_field(config_item('database_ratings_ratings_table'));
		$this->dbforge->create_table('ratings');

		// Settings & Create Folders
		$settings = $this->installer->install_settings('ratings', config_item('ratings_settings'));
	
		if ($settings == TRUE)
		{
            $message = array('status' => 'success', 'message' => 'Yay, the Ratings App was installed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Dang Ratings App could not be installed');
        }		
		
		$this->response($message, 200);
	} 
	
	function view_get()
	{
    	$search_by	= $this->uri->segment(4);
    	$search_for	= $this->uri->segment(5);	
	
		// Insert
		if ($ratings = $this->social_tools->get_ratings_view($search_by, $search_for))
		{
        	$message = array('status' => 'success', 'message' => 'Ratings were found', 'ratings' => $ratings);
        }
        else
        {
	        $message = array('status' => 'error', 'message' => 'Oops could not find any ratings');
        }

        $this->response($message, 200);		
	
	}
    
    function create_vote_authd_post()
    {
    	$this->form_validation->set_rules('object', 'Object', 'required');
		$this->form_validation->set_rules('object_id', 'Object Id', 'integer');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('rating', 'Rating', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{
			if ($this->input->post('site_id')) $site_id = $this->input->post('site_id');
			else $site_id = config_item('site_id');
			
        	$rating_data = array(
        		'site_id'		=> $site_id,
        		'user_id'		=> $this->oauth_user_id,
        		'object'		=> $this->input->post('object'),
        		'object_id'		=> $this->input->post('object_id'),
        		'type'			=> $this->input->post('type')
        	);

			// Check If Exists
			if ($check_rating = $this->ratings_model->check_rating($rating_data))
			{
				// Check If Different
				if ($check_rating->rating != $this->input->post('rating'))
				{
					$update = $this->ratings_model->update_rating($check_rating->rating_id, array('rating' => $this->input->post('rating')));
		        	$count = $this->ratings_model->get_ratings_count_up_down($this->input->post('object'), $this->input->post('object_id'));
		        	$message = array('status' => 'success', 'message' => 'Your vote was switched', 'rating' => $update, 'count' => $count);
				}
				else
				{
					$message = array('status' => 'error', 'message' => 'Oops your vote already exists');
				}
			}
			else
			{
				// Rating
				$rating_data['rating'] = $this->input->post('rating');
				$rating_data['ip_ratings'] = $this->input->ip_address();

				if ($rating = $this->ratings_model->add_rating($rating_data))
				{
					$count = $this->ratings_model->get_ratings_count_up_down($this->input->post('object'), $this->input->post('object_id'));
		        	$message = array('status' => 'success', 'message' => 'Your vote was recorded', 'rating' => $rating, 'count' => $count);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops could not create vote');
		        }
			}
		}
		else 
		{	
	        $message = array('status' => 'error', 'message' => validation_errors());
		}			

        $this->response($message, 200);	
	}
    

    function create_authd_post()
    {    
    	$this->load->model('data_model');

		$data = array(
			'user_id'	=> $this->oauth_user_id,
			'text'		=> $this->input->post('text')
		);

		// Add Data
		if ($add_data = $this->data_model->add_data($data))
		{
        	$message = array('status' => 'success', 'message' => 'Data successfully created', 'data' => $add_data);
        }
        else
        {
	        $message = array('status' => 'error', 'message' => 'Oops unable to add data');
        }
	
        $this->response($message, 200);
    }
    
    function update_authd_get()
    {
    	$this->load->model('data_model');
    
    	$udpate_data = array(
    		'text'	=> $this->input->post('text')
    	);
    
		$update = $this->social_tools->update_data($this->get('id'), $update_data);			
    	
        if($update)
        {
            $message = array('status' => 'success', 'message' => 'Data was update');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not update data');
        } 

        $this->response($message, 200);           
    }  

    function destroy_authd_get()
    { 
       	$this->load->model('data_model'); 
         
    	if ($this->data_model->delete_data($this->get('id')))
    	{   	
    		$message = array('status' => 'success', 'message' => 'Data was deleted');
    	}
    	else
    	{
    		$message = array('status' => 'error', 'message' => 'Oops Data was not deleted');        	
    	}
        
        $this->response($message, 200);
    }

}