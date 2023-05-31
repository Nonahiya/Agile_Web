<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Discussion extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->model('Discussion_model', 'model');
    }

    public function index_get()
    {
        $id = (int) $this->get('id');

        if ($id == NULL)
        {
            $discussions = $this->model->getAll();
            if ($discussions)
            {
                $this->set_response([
                    'status' => TRUE,
                    'code' => 200,
                    'message' => 'Here are all the discussions in the database.',
                    'discussion'   => $discussions,
                ], REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'error' => 'No discussions were found.'
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
                $discussion = $this->model->getById($id);
                if ($discussion)
                {
                    $this->set_response([
                        'status' => TRUE,
                        'code' => 200,
                        'message' => 'Here are discussion with id '.$id.' in the database.',
                        'discussion'   => $discussion,
                    ], REST_Controller::HTTP_OK); 
                }
                else
                {
                    $this->set_response([
                        'status' => FALSE,
                        'error' => 'Discussion with id '.$id.' could not be found.'
                    ], REST_Controller::HTTP_NOT_FOUND); 
                }
            }
        }
    }

    public function index_post()
    {
        $discussion = $this->model->create(); 

        $this->set_response([
            'discussion' => $discussion,
            'message' => 'Discussion created successfully.'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_put($id)
    {
        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        $this->model->update($id);
        
        $this->set_response([
            'id' => $id,
            'message' => 'Discussion edited successfully.'
        ], REST_Controller::HTTP_OK); 
    }

    public function index_delete($id)
    {
        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        $this->model->delete($id);

        $this->response(['message' => 'Discussion deleted successfully.'], REST_Controller::HTTP_OK);
    }
}

/* End of file Discussion.php and path \application\controllers\Discussion.php */
