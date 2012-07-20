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
	}

    /* Install App */
	function install_get()
	{
		// Load
		$this->load->library('installer');
		$this->load->config('install');
		$this->load->dbforge();

		// Create Data Table
		$this->dbforge->add_key('data_id', TRUE);
		$this->dbforge->add_field(config_item('database_ratings_data_table'));
		$this->dbforge->create_table('data');

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
    
    function create_public_post()
    {
		$this->form_validation->set_rules('content_id', 'Content', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('rating', 'Rating', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{
			if ($this->input->post('site_id')) $site_id = $this->input->post('site_id');
			else $site_id = config_item('site_id');
			
        	$rating_data = array(
        		'site_id'		=> $site_id,
        		'user_id'		=> $this->input->post('user_id'),
        		'content_id'	=> $this->input->post('content_id'),
        		'type'			=> $this->input->post('type'),
    			'rating'		=> $this->input->post('rating'),
    			'ip_address'	=> $this->input->ip_address()
        	);
			
			// Check If Exists
			if ($check_rating = $this->social_tools->check_rating($rating_data))
			{
				$message = array('status' => 'error', 'message' => 'Oops that rating already exists');
			}
			else
			{
				// Insert
				if ($rating = $this->social_tools->add_rating($rating_data))
				{
		        	$message = array('status' => 'success', 'message' => 'Rating was recorded', 'rating' => $rating);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops could not create rating');
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