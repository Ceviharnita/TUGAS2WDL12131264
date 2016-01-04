<?php
class Categories_model extends CI_Model {

    var $CategoryName  = '';
    var $Description = '';
	var $Picture = '';
    

    function __construct()
    {        
        parent::__construct();
    }
    
    function get_categories()
    {
        $query = $this->db->get('categories');
        return $query->result();
    }

    function get_categories_by_id($id)
    {
        $this->db->where('CategoryID',$id);
        $query = $this->db->get('categories');
        return $query->row();
    }

    function insert_entry()
    {
        $this->CategoryName  = $this->input->post('CategoryName',true); 
        $this->Description   = $this->input->post('Description',true);  
		$this->Picture = $this->upload->file_name;
        return $this->db->insert('categories', $this);
    }

    function update_entry()
    {
        $this->CategoryName  = $this->input->post('CategoryName',true); 
        $this->Description   = $this->input->post('Description',true);         
        return $this->db->update('categories', $this, array('CategoryID' => $this->input->post('id',true)));
    }

    function hapus($id)
    {
        $this->db->where('CategoryID',$id);
        return $this->db->delete('categories');
    }

    function cek_dependensi($id)
    {
        $this->db->where('CategoryID',$id);
        $query = $this->db->count_all('categories');
        return ($query==0) ? true : false;
    }
	
	function do_upload()
        {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                        $error = array('error' => $this->upload->display_errors());

                      return $this->mytemplate->loadBackend('frmcategories', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                      return  $this->mytemplate->loadBackend('upload_success', $data);
                }
        }
}