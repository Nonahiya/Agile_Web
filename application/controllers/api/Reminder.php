<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Reminder extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->model('Reminder_model', 'model');
    }

    public function index_get()
    {
        $id = (int) $this->get('id');

        if ($id == NULL)
        {
            $reminders = $this->model->getAll();
            if ($reminders)
            {
                $this->set_response([
                    'status' => TRUE,
                    'code' => 200,
                    'message' => 'Here are all the reminders in the database.',
                    'reminder'   => $reminders,
                ], REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'error' => 'No reminders were found.'
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
                $reminder = $this->model->getById($id);
                if ($reminder)
                {
                    $this->set_response([
                        'status' => TRUE,
                        'code' => 200,
                        'message' => 'Here are reminder with id '.$id.' in the database.',
                        'reminder'   => $reminder,
                    ], REST_Controller::HTTP_OK); 
                }
                else
                {
                    $this->set_response([
                        'status' => FALSE,
                        'error' => 'Reminder with id '.$id.' could not be found.'
                    ], REST_Controller::HTTP_NOT_FOUND); 
                }
            }
        }
    }

    public function index_post()
    {
        $reminder = $this->model->create(); 

        $this->set_response([
            'reminder' => $reminder,
            'message' => 'Reminder created successfully.'
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
            'message' => 'Reminder edited successfully.'
        ], REST_Controller::HTTP_OK); 
    }

    public function index_delete($id)
    {
        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        $this->model->delete($id);

        $this->response(['message' => 'Reminder deleted successfully.'], REST_Controller::HTTP_OK);
    }
}

/* End of file Reminder.php and path \application\controllers\api\Reminder.php */
