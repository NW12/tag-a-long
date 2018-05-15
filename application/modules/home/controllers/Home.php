<?php

/*
----------------------------
Home     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //error_reporting(E_ALL);
        // Display errors in output
        //ini_set('display_errors', 1);
        $X_API_KEY = $this->common->getHeaders('Tag-A-Long-Api-Key');
        $this->secret_key = $X_API_KEY; //'zRyxpCaGosehZTcNHlQfDPnAWmdBrjKFJkXIMLti-IBLyZsiG'
        
        //$this->common->chechSecurity();
       
        $this->load->model('home_model');
        //$this->load->library('emailutility');
    }
    public function index() {

      
    }
    
    function email_verification($user){
      $user_id = $this->common->decode($user);
      $check = $this->home_model->isUserInactive($user_id);
        
            if($check == 0){
                $post_data = array();
                $post_data['is_verified'] = '1';
                $up = $this->home_model->update('users', $post_data, array('user_id' => $user_id));
                $data = array();
                $data = $this->home_model->get_user_data($user_id);
                
                $data['user_id']        = $data['user_id'];
                $data['name']           = $data['name'];
                $data['email']          = $data['email'];
                $data['phone_no']       = $data['phone_no'];
                $data['avatar']         = $data['avatar'];
                $data['fb_url']         = $data['fb_url'];
                $data['tw_url']         = $data['tw_url'];
                $data['soundcloud_url'] = $data['soundcloud_url'];
                $data['web_url']        = $data['web_url'];
                $data['cover_photo']    = $data['cover_photo'];
                $data['is_verified']    = $data['is_verified'];
                $data['status'] = 1; 
                $data['message'] = 'Congratulation! Your account has been verified successfully.';
                $this->makeLog($user_id, "Verify email address", NULL, NULL, "User successfully verifed email address");
                
            }
            else if ($check == 1) {
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
                
            }
            else{
                
                $data['status'] = 0;
                $data['error'] = 202;
                $data['message'] = 'User "' . $email . '" not exists. Please try another email.';
                
           }
            header('Content-Type: application/json');
            echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
            exit;
    }
    
    function forgotPassword($user_id){
       
        $user_id = $this->common->decode($user_id);
      
        $check = $this->home_model->isUserInactive($user_id);
        
            if($check == 0){
                $post_data = array();
                $data['status'] = 1; 
                $data['user_id'] = $user_id;
                $data['message'] = 'Password change request';
                $this->makeLog($user_id, "Verify email address", NULL, NULL, "User successfully verifed email address");
                
            }
            else if ($check == 1) {
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
                
            }
            else{
                
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Invalid data provided.';
                
           }
            header('Content-Type: application/json');
            echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
            exit;
    }
    
    
       function makeLog ($user_id,$action,$class_id,$target_user_id,$description){
        $post_data = array();
        if($user_id){
            $post_data['user_id'] = $user_id;
        }
        if ($action){
            $post_data['action'] = $action;
        }
        if($class_id){
            $post_data['class_id'] = $class_id;
        }
        if($target_user_id){
            $post_data['target_user_id'] = $target_user_id;
        }
        if($description){
            $post_data['description'] = $description;
        }
        $this->home_model->create("activity_logs",$post_data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
