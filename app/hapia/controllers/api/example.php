<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Example extends REST_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index_get()
    {
        $this->response(['Hello!'], 200);
    }
}