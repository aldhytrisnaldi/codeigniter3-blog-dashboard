<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subcategory_model extends CI_Model
{

    public $table   = 'tb_subcategory';
    public $id      = 'id_subcategory';
    public $order   = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function json()
    {
        $this->datatables->select('id_subcategory,category,subcategory,subcategory_slug');
        $this->datatables->from('tb_subcategory');
        $this->datatables->join('tb_category', 'tb_subcategory.id_parent = tb_category.id_category');
        $this->datatables->add_column('action', anchor(site_url('dashboard/subcategory/update/$1'),'<b>Update</b>','class="btn btn-xs bg-navy"')."  ".anchor(site_url('dashboard/subcategory/delete/$1'),'<b>Delete</b>','class="btn btn-xs bg-navy" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_subcategory');
        return $this->datatables->generate();
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function total_rows($q = NULL)
    {
        $this->db->like('id_subcategory', $q);
        $this->db->or_like('id_parent', $q);
        $this->db->or_like('subcategory', $q);
        $this->db->or_like('subcategory_slug', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_subcategory', $q);
        $this->db->or_like('id_parent', $q);
        $this->db->or_like('subcategory', $q);
        $this->db->or_like('subcategory_slug', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    public function category()
    {
        $sql_prod=$this->db->get('tb_category');
        if($sql_prod->num_rows()>0)
        {
            foreach ($sql_prod->result_array() as $row)
                {
                    $result['']= '- Choose a Category -';
                    $result[$row['id_category']]= ucwords(strtolower($row['category']));
                }
			return $result;
		}
    }
}