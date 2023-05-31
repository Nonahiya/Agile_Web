<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Reminder_model extends CI_Model 
{
    private $_table = 'reminder';
    
    public $id;
    public $leader_id;
    public $content;
    public $date;
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
    
    public function getNewestByLeaderId($leader_id) {
        $query = "SELECT * from $this->_table WHERE leader_id = '$leader_id' ORDER BY id DESC";
        return  $this->db->query($query)->row();
    }

    public function create() {
        $this->leader_id  = $_POST['leader_id'];
        $this->content  = $_POST['content'];
        $this->date  = gmdate('Y-m-d H:i:s', $_POST['date']);
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->getNewestByLeaderId($this->leader_id);
    }
  
    public function update($id) {
        if ($this->content != null || $this->content != "")  {
            $this->content  = md5($_POST['content']);
        }
        if ($this->date != null || $this->date != "")  {
            $this->date  = md5($_POST['date']);
        }
        $this->updated_at = date('Y-m-d H:i:s');
        return $this->db->update($this->_table, $this, array("id" => $id));
    }                        
                    
    public function delete($id) {
        return $this->db->delete($this->_table, $this, array("id" => $id));
    }                       
}


/* End of file Reminder_model.php and path \application\models\Reminder_model.php */
