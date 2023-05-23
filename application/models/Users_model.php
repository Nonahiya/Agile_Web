<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Users_model extends CI_Model 
{
    private $_table = 'users';

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
        $this->birthdate  = $_POST['birthdate'];
        $this->phone  = $_POST['phone'];
        $this->role  = $_POST['role'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->getByEmail($this->email);
    }
                        
}


/* End of file Users_model.php and path \application\models\Users_model.php */
