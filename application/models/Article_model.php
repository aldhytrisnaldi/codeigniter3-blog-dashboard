<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends CI_Model
{

    public $table   = 'tb_article';
    public $id      = 'id_article';
    public $order   = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function json()
    {
        $this->datatables->select('id_article,title,username,category,subcategory,status');
        $this->datatables->from('tb_article');
        $this->datatables->join('tb_category', 'tb_article.id_cat = tb_category.id_category');
        $this->datatables->join('tb_subcategory', 'tb_article.id_subcat = tb_subcategory.id_subcategory');
        $this->datatables->join('users', 'tb_article.author = users.id');
        $this->datatables->add_column('action', anchor(site_url('dashboard/article/update/$1'),'<b>Update</b>','class="btn btn-xs bg-navy"')." ".anchor(site_url('dashboard/article/delete/$1'),'<b>Delete</b>','class="btn btn-xs bg-navy" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_article');
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
        $this->db->like('id_article', $q);
        $this->db->or_like('author', $q);
        $this->db->or_like('title', $q);
        $this->db->or_like('slug', $q);
        $this->db->or_like('description', $q);
        $this->db->or_like('id_cat', $q);
        $this->db->or_like('status', $q);
        $this->db->or_like('photos', $q);
        $this->db->or_like('created_at', $q);
        $this->db->or_like('updated_at', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_article', $q);
        $this->db->or_like('author', $q);
        $this->db->or_like('title', $q);
        $this->db->or_like('slug', $q);
        $this->db->or_like('description', $q);
        $this->db->or_like('id_cat', $q);
        $this->db->or_like('status', $q);
        $this->db->or_like('photos', $q);
        $this->db->or_like('created_at', $q);
        $this->db->or_like('updated_at', $q);
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

    public function delete_by_id($id)
    {
        $this->db->select("photos");
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row();
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

    public function subcategory($id)
    {
        $this->db->where('id_parent',$id);
        $sql_prod=$this->db->get('tb_subcategory');
        if($sql_prod->num_rows()>0)
        {
            foreach ($sql_prod->result_array() as $row)
                {
                    $result['']= '- Choose a Subcategory -';
                    $result[$row['id_subcategory']]= ucwords(strtolower($row['subcategory']));
                }
			return $result;
		}
    }
}