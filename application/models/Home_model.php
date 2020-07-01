<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function c_admin()
    {
      return $this->db->query("select * from users_groups where group_id = 1 ");
    }

    public function c_member()
	  {
		  return $this->db->query("select * from users_groups where group_id = 2 ");
    }

    public function c_active()
	  {
		  return $this->db->query("select * from users where active = 1 ");
    }

    public function c_deactive()
	  {
		  return $this->db->query("select * from users where active = 0 ");
    }
        
    // function c_admin($where = '')
	// {
	// 	return $this->db->query("select * from users $where; ");
	// }

}