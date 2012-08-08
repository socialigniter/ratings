<?php

class Ratings_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_ratings($object, $object_id)
    {
 		$this->db->select('*');
 		$this->db->from('ratings');   
 		$this->db->where('object', $object); 
		$this->db->where('object_id', $object_id);
 		$this->db->order_by('created_at', 'desc'); 
 		$result = $this->db->get();	
 		return $result->result();	      
    }

    function get_ratings_count_up_down($object, $object_id)
    {
 		$this->db->select('rating');
 		$this->db->from('ratings');   
 		$this->db->where(array('object' => $object, 'object_id' => $object_id, 'rating' => 'up')); 
 		$up = $this->db->count_all_results();

 		$this->db->select('rating');
 		$this->db->from('ratings');   
 		$this->db->where(array('object' => $object, 'object_id' => $object_id, 'rating' => 'down')); 
 		$down = $this->db->count_all_results();

 		return array('up' => $up, 'down' => $down);      
    }
    
    function get_ratings_view($parameter, $value)
    {
    	if (in_array($parameter, array('site_id', 'user_id', 'object', 'object_id', 'type', 'rating', 'ip_address')))
    	{
	 		$this->db->select('*');
	 		$this->db->from('ratings');
	 		$this->db->where($parameter, $value);
	 		$this->db->order_by('created_at', 'desc');	 		
	 		$result = $this->db->get();
	 		return $result->result();
		}
		else
		{
			return FALSE;
		}
    }    
    
	function get_ratings_likes_user($user_id)
    {
 		$this->db->select('ratings.*, users.username, users.gravatar, users.name, users.image');
 		$this->db->from('ratings');    
 		$this->db->join('users', 'users.user_id = ratings.user_id'); 				
		$this->db->where('ratings.user_id', $user_id);
 		$this->db->order_by('created_at', 'desc'); 
 		$result = $this->db->get();	
 		return $result->result();    	
    }
    
    function check_rating($rating_data)
    {
 		$this->db->select('*');
 		$this->db->from('ratings');    
		$this->db->where($rating_data);
 		$result = $this->db->get()->row();
 		return $result;	      
    }

    function add_rating($rating_data)
    {
 		$rating_data['created_at'] = unix_to_mysql(now());
 		$rating_data['updated_at'] = unix_to_mysql(now());
		$this->db->insert('ratings', $rating_data);
		$rating_data['rating_id'] = $this->db->insert_id();
		return $rating_data;	
    }
    
    function update_rating($rating_id, $rating_data)
    {
		$rating_data['updated_at'] = unix_to_mysql(now());
		$this->db->where('rating_id', $rating_id);
		$this->db->update('ratings', $rating_data);
		return $this->db->get_where('ratings', array('rating_id' => $rating_id))->row();	
    }
    
}