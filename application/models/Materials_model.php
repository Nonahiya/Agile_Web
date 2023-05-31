<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Materials_model extends CI_Model 
{
    private $_table = 'materials';
    
    public $id;
    public $user_id;
    public $title;
    public $content;
    public $created_at;
    public $updated_at;
    
    public function __construct() {
        parent::__construct();
    }
        
    public function getAll() {
        return $this->db->get($this->_table)->result_array();
    }

    public function getById($id) {
        $query = "SELECT * from $this->_table WHERE id = '$id'";
        return  $this->db->query($query)->row();
    }
   
    public function getNewestByUserId($user_id) {
        $query = "SELECT * from $this->_table WHERE user_id = '$user_id' ORDER BY id DESC";
        return  $this->db->query($query)->row();
    }

    public function create() {
        $this->user_id  = $_POST['user_id'];
        $this->title  = $_POST['title'];
        $this->content  = $_POST['content'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->getNewestByUserId($this->user_id);
    }
  
    public function update($id) {
        if ($this->title != null || $this->title != "")  {
            $this->title  = md5($_POST['title']);
        }
        if ($this->content != null || $this->content != "")  {
            $this->content  = md5($_POST['content']);
        }
        $this->updated_at = date('Y-m-d H:i:s');
        return $this->db->update($this->_table, $this, array("id" => $id));
    }                        
                    
    public function delete($id) {
        return $this->db->delete($this->_table, $this, array("id" => $id));
    }                                             
}


/* End of file Materials_model.php and path \application\models\Materials_model.php */
