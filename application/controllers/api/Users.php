<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        
        $this->load->model('Users_model', 'model');
    }

    public function index_get()
    {
        $id = (int) $this->get('id');

        if ($id == NULL)
        {
            $users = $this->model->getAll();
            if ($users)
            {
                $this->set_response([
                    'status' => TRUE,
                    'code' => 200,
                    'message' => 'Here are all the users in the database.',
                    'users'   => $users,
                ], REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'error' => 'No users were found.'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
        else {
            if ($id <= 0)
            {
                $this->set_response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            else
            {
                $user = $this->model->getById($id);
                if ($user)
                {
                    $this->set_response([
                        'status' => TRUE,
                        'code' => 200,
                        'message' => 'Here are user with id '.$id.' in the database.',
                        'user'   => $user,
                    ], REST_Controller::HTTP_OK); 
                }
                else
                {
                    $this->set_response([
                        'status' => FALSE,
                        'error' => 'User with id '.$id.' could not be found.'
                    ], REST_Controller::HTTP_NOT_FOUND); 
                }
            }
        }
    }

    public function index_post()
    {
        $email = $this->post('email');
        $emailChecker = $this->model->getByEmail($email);
        if (!$emailChecker)
        { 
            $user = $this->model->create(); 

            $this->set_response([
                'user' => $user,
                'message' => 'User registered successfully.'
            ], REST_Controller::HTTP_CREATED);
        }
        else
        {
            $this->set_response([
                'error' => 'User with the email already exist.'
            ], REST_Controller::HTTP_CONFLICT); 
        }
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        
        $condition['returnType'] = 'single';
        $condition['conditions'] = array(
            'email' => $email,
            'password' => md5($password),
        );

        $user = $this->model->getRows($condition);

        if($user)
        {
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message' => 'Login successfully.',
                'user' => $user
            ], REST_Controller::HTTP_OK); 
        } 
        else
        {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Invalid email and password.'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
}

/* End of file Users.php and path \application\controllers\Users.php */
