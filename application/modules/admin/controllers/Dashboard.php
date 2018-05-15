<?php

/*
----------------------------
DASHBOARD     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Dashboard extends CI_Controller {



    public function __construct() {

        parent::__construct();

        

        //check if admin login

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

    }



// End __construct

    /**

     * Method: index

     */



    public function index() {

        $data = array();

        $data['content'] = $this->load->view('dashboard', $data, true);

        $this->load->view('templete-view', $data);

    }



}



//End Class