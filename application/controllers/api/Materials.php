<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Materials extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->model('Materials_model', 'model');
    }

    public function index_get()
    {
        $id = (int) $this->get('id');

        if ($id == NULL)
        {
            $materials = $this->model->getAll();
            if ($materials)
            {
                $this->set_response([
                    'status' => TRUE,
                    'code' => 200,
                    'message' => 'Here are all the materials in the database.',
                    'materials'   => $materials,
                ], REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'error' => 'No materials were found.'
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
                $materials = $this->model->getById($id);
                if ($materials)
                {
                    $this->set_response([
                        'status' => TRUE,
                        'code' => 200,
                        'message' => 'Here are materials with id '.$id.' in the database.',
                        'materials'   => $materials,
                    ], REST_Controller::HTTP_OK); 
                }
                else
                {
                    $this->set_response([
                        'status' => FALSE,
                        'error' => 'Materials with id '.$id.' could not be found.'
                    ], REST_Controller::HTTP_NOT_FOUND); 
                }
            }
        }
    }

    public function index_post()
    {
        $materials = $this->model->create(); 

        $this->set_response([
            'materials' => $materials,
            'message' => 'Materials created successfully.'
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
            'message' => 'Materials edited successfully.'
        ], REST_Controller::HTTP_OK); 
    }

    public function index_delete($id)
    {
        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        $this->model->delete($id);

        $this->response(['message' => 'Materials deleted successfully.'], REST_Controller::HTTP_OK);
    }
}

/* End of file Materials.php and path \application\controllers\api\Materials.php */
