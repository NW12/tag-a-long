<?php

/*
----------------------------
Login     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Login extends CI_Controller {



    public function __construct() {

        parent::__construct();      

      $this->load->model('login_model');

    }



//End __construct

    /**

     * Mrethod: index

     */

    public function index() {

        

        $data = array();

        if ($this->input->post()) {

            $email = $this->input->get_post('email');

            $password = $this->input->get_post('password');



            $response = $this->login_model->ajaxLogin($email, $password);

            if ($response == true) {

                $remember = $this->input->get_post("rememberme");

                if ($remember == 1) {



                    $past = time() - 5;

                    //this makes the time 5 seconds ago

                    setcookie("userEmail", NULL, $past);

                    setcookie("userEmail", base64_encode(base64_encode($email)), time() + 3600 * 24, "/", "");

                    setcookie("userpassword", NULL, $past);

                    setcookie("userpassword", base64_encode(base64_encode($password)), time() + 3600 * 24, "/", "");

                }

                $this->session->set_flashdata('success_message', 'You have login successfully. Please wait...');

                redirect(base_url('admin/dashboard'));

                exit;

            } else {

                $this->session->set_flashdata('error_message', 'The email or password you entered is incorrect. Please try again (make sure your caps lock is off).');

            }

        }

        $this->load->view('login', $data);

    }



    /**

     * Method: logout

     * */

    public function logout() {

        $past = time() - 3600;

        setcookie("userEmail", "", $past);

        setcookie("userpassword", "", $past);

        setcookie("userEmail", '', $past, "/", "");

        setcookie("userpassword", '', $past, "/", "");



        $this->session->unset_userdata(array(

            'user_id' => '',

            'role_id' => '',

            'full_name' => '',

            'first_name' => '',

            'last_name' => '',

            'user_name' => '',

            'photo' => '',

            'user_is_logged_in' => '',

            'email' => '',

            'is_admin' => FALSE));

        redirect(base_url('admin/login'), 'refresh');

    }



}



//End Class