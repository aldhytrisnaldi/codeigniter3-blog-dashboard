<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model
{
    public function get_all($id = NULL)
    {
        if($id === NULL)
        {
            return $this->db->get('crud')->result_array();
        }
        else
        {
            return $this->db->get_where('crud', ['id' => $id])->result_array();
        }
    }

    public function delete($id)
    {
        $this->db->delete('crud', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function create($data)
    {
        $this->db->insert('crud', $data);
        return $this->db->affected_rows();
    }

    public function update($data, $id)
    {
        $this->db->update('crud',$data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}