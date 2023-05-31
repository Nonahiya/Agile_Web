<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class User_model extends CI_Model 
{
    private $_table = 'user';

    public $id;
    public $email;
    public $password;
    public $name;
    public $gender;
    public $city;
    public $birthdate;
    public $phone;
    public $role;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();

    }
    
    public function getAll() {
        return $this->db->get($this->_table)->result_array();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->_table);
        
        if(array_key_exists("conditions",$params)){
            foreach($params['conditions'] as $key => $value){
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();    
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():false;
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():false;
            }
        }
        return $result;
    }

    public function getById($id) {
        $query = "SELECT * from $this->_table WHERE id = '$id'";
        return  $this->db->query($query)->row();
    }

    public function getByEmail($email) {
        $query = "SELECT * from $this->_table WHERE email = '$email'";
        return  $this->db->query($query)->row();
    }
    
    public function create()
    {
        $this->email  = $_POST['email'];
        $this->password  = md5($_POST['password']);
        $this->name  = $_POST['name'];
        $this->gender  = $_POST['gender'];
        $this->city  = $_POST['city'];
        $this->birthdate  = gmdate('Y-m-d H:i:s', $_POST['birthdate']);
        $this->phone  = $_POST['phone'];
        $this->role  = $_POST['role'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->getByEmail($this->email);
    }
                        
}


/* End of file Users_model.php and path \application\models\Users_model.php */
