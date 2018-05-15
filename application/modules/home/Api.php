<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $X_API_KEY = $this->common->getHeaders('Tag-A-Long-Api-Key');
        $this->secret_key = $X_API_KEY; //'zRyxpCaGosehZTcNHlQfDPnAWmdBrjKFJkXIMLti-IBLyZsiG'

        $this->common->chechSecurity();

        $this->load->model('api_model');
        $this->load->library('emailutility');
    }

    
    
    /**
     * Method: Test
     * params: Posted Data $post
     * Return: Json
     */
    
    function upAndRunning() {
         $data = array();
         $data['status'] = 1;
         $data['message'] = "We are up and running";
         
         header('Content-Type: application/json');
         echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
         exit;
    }
    
    

    /**
     * Method: login
     * params: Posted Data $post
     * Return: Json
     */
    function login() {

        $post_data = array();
        $data = array();
        if ($_POST['email'] <> '' && $_POST['password'] <> '') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $response = $this->api_model->ajaxLogin($email, $password);

            if ($response <> 0 && $response <> -1) {

                $data = $this->api_model->get_user_data($response);
                if($data['is_verified'] == 0){
                    $send_data['status'] = 1;
                    $send_data['user_id'] = $data['user_id'];
                    $send_data['is_verified'] = 0;
                    $send_data['message'] = 'Your email address is not verified. Kindly verify your email.';
                    $this->makeLog($data['user_id'], "User login failed", NULL, NULL, "User login failed, email address not verified");
                    header('Content-Type: application/json');
                    echo json_encode($send_data, JSON_NUMERIC_CHECK);
                    exit;
                }
                $post_data['last_sign_in'] = date('Y-m-d H:i:s');
                $post_data['is_signed_in'] = '1';
                $results = $this->api_model->update('users', $post_data, array('user_id' => $data['user_id']));
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
                
                $this->makeLog($data['user_id'], "User logged in", NULL, NULL, "User logged in using email address");
            } 
            
            else if ($response == -1){
                $data['status'] = 0;
                $data['error'] = 205;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['error'] = 205;
                $data['message'] = 'The email or password you entered is incorrect. Please try again.';
            }
        }  else if ($_POST['user_fbId'] <> '' && $_POST['user_fbId'] <> 0) {
                
                $verify = $this->api_model->verify_user('user_fbId',$_POST['user_fbId']);
                
            if ($verify == 1) {
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'You have not created an account, Please create account first.';
            } else {
                $insert_id = getVal('user_id', 'users', 'user_fbId', $_POST['user_fbId']);
               
                $data = $this->api_model->get_user_data($insert_id);
                
                
                $post_data['last_sign_in'] = date('Y-m-d H:i:s');
                $post_data['is_signed_in'] = '1';
                $results = $this->api_model->update('users', $post_data, array('user_id' => $data['user_id']));
                
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
                
                $this->makeLog($insert_id, "User logged in", NULL, NULL, "User logged in using FB");
            }
        }  else if ($_POST['user_twid'] <> '' && $_POST['user_twid'] <> 0) {
            $verify = $this->api_model->verify_user('user_twid',$_POST['user_twid']);
            if ($verify == 1) {
                $data['status'] = 0;
                $data['error'] = 203;
                $data['message'] = 'You have not created an account, Please create account first.';
            } else {
                $insert_id = getVal('user_id', 'users', 'user_twid', $_POST['user_twid']);
                $data = $this->api_model->get_user_data($insert_id);
                $post_data['last_sign_in'] = date('Y-m-d H:i:s');
                $post_data['is_signed_in'] = '1';
                $results = $this->api_model->update('users', $post_data, array('user_id' => $data['user_id']));
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
                $this->makeLog($insert_id, "User logged in", NULL, NULL, "User logged in using twitter");
            }
        }
        else if ($_POST['user_inid'] <> '' && $_POST['user_inid'] <> 0) {
            $verify = $this->api_model->verify_user('user_inid',$_POST['user_inid']);
            if ($verify == 1) {
                $data['status'] = 0;
                $data['error'] = 202;
                $data['message'] = 'You have not created an account, Please create account first.';
            } else {
                $insert_id = getVal('user_id', 'users', 'user_inid', $_POST['user_inid']);
                $data = $this->api_model->get_user_data($insert_id);
                $post_data['last_sign_in'] = date('Y-m-d H:i:s');
                $post_data['is_signed_in'] = '1';
                $results = $this->api_model->update('users', $post_data, array('user_id' => $data['user_id']));
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
                
                $this->makeLog($insert_id, "User logged in", NULL, NULL, "User logged in using twitter");
            }
        }
        else if ($_POST['user_gid'] <> '' && $_POST['user_gid'] <> 0) {
            $verify = $this->api_model->verify_user('user_gid',$_POST['user_gid']);
            if ($verify == 1) {
                $data['status'] = 0;
                $data['error'] = 201;
                $data['message'] = 'You have not created an account, Please create account first.';
            } else {
                $insert_id = getVal('user_id', 'users', 'user_gid', $_POST['user_gid']);
                $data = $this->api_model->get_user_data($insert_id);
                $post_data['last_sign_in'] = date('Y-m-d H:i:s');
                $post_data['is_signed_in'] = '1';
                $results = $this->api_model->update('users', $post_data, array('user_id' => $data['user_id']));
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
               
                $this->makeLog($insert_id, "User logged in", NULL, NULL, "User logged in using twitter");
            }
        }
        
         else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }     
        if($data['status'] == 1){
            $this->resetBadgeNumber($data['user_id']);
        }
   
        header('Content-Type: application/json');
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }

    
    
    /**
     * Method: register
     * params: Posted Data $post
     * Return: Json
     */
    function register() {
        $post_data = array();
        $data = array();
      
        if ($_POST['user_fbId'] <> '' && $_POST['user_fbId'] <> 0) {
            $verify = $this->api_model->verify_user('user_fbId',$_POST['user_fbId']);
            
            if ($verify == 1) {
                $post_data['user_fbId'] = $_POST['user_fbId'];

                //$post_data['full_name'] = $_POST['full_name'];
                //$name = explode(' ', $_POST['full_name']);
                //$post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
                //$post_data['last_name'] = $name[1] <> '' ? $name[1] : '';
//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
                
                $post_data['name'] = $_POST['name'];
                if ($_POST['email'] <> '') {
                    $post_data['email'] = $_POST['email'];
                } else {
                    $post_data['email'] = '';
                }
                
                $post_data['is_active'] = 1;
                $post_data['avatar'] = $this->common->do_upload_FBpicture($_POST['user_fbId']);
                //$post_data['created'] = time();
                 $post_data['created'] = date('Y-m-d H:i:s');
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                $post_data['is_verified'] = 1;
                $results = $this->api_model->create('users', $post_data);
                $insert_id = $this->db->insert_id();
                if ($results) {

                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
                //$data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
                //$data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
                
//                $del_address = $this->api_model->get_user_delivery_address($data['user_id']);
//                $data['delivery_address'] = $del_address;
                   // $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "FB User Signup", NULL, NULL, "User created new account using facebook");
                
                } else {
                    $data['status'] = 0;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $insert_id = getVal('user_id', 'users', 'user_fbId', $_POST['user_fbId']);
                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
                //$data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
                //$data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];

// $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "FB User Signup", NULL, NULL, "User already have fb associated account, returning same account");
            }
        } 
        else if ($_POST['user_gid'] <> '' && $_POST['user_gid'] <> 0) {
            $verify = $this->api_model->verify_user($_POST['user_gid']);
            if ($verify == 1) {
                $post_data['user_gid'] = $_POST['user_gid'];

                //$post_data['full_name'] = $_POST['full_name'];
                //$name = explode(' ', $_POST['full_name']);
                //$post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
                //$post_data['last_name'] = $name[1] <> '' ? $name[1] : '';
//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
                
                $post_data['name'] = $_POST['name'];
                if ($_POST['email'] <> '') {
                    $post_data['email'] = $_POST['email'];
                } else {
                    $post_data['email'] = '';
                }
                
                $post_data['is_active'] = 1;
                $post_data['avatar'] = $this->common->do_upload_FBpicture($_POST['user_gid']);
                //$post_data['created'] = time();
                $post_data['created'] = date('Y-m-d H:i:s');
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                $post_data['is_verified'] = 1;
                $results = $this->api_model->create('users', $post_data);
                $insert_id = $this->db->insert_id();
                if ($results) {

                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
              //  $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
              //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
                
//                $del_address = $this->api_model->get_user_delivery_address($data['user_id']);
//                $data['delivery_address'] = $del_address;
                   // $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Google plus User Signup", NULL, NULL, "User created new account using facebook");
                
                } else {
                    $data['status'] = 0;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $insert_id = getVal('user_id', 'users', 'user_gid', $_POST['user_gid']);
                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
               // $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
                //$data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];

// $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Google Plus User Signup", NULL, NULL, "User already have Google plus associated account, returning same account");
            }
        } 
        else if ($_POST['user_inid'] <> '' && $_POST['user_inid'] <> 0) {
            $verify = $this->api_model->verify_user($_POST['user_inid']);
            if ($verify == 1) {
                $post_data['user_inid'] = $_POST['user_inid'];

                //$post_data['full_name'] = $_POST['full_name'];
                //$name = explode(' ', $_POST['full_name']);
                //$post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
                //$post_data['last_name'] = $name[1] <> '' ? $name[1] : '';
//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
                
                $post_data['name'] = $_POST['name'];
                if ($_POST['email'] <> '') {
                    $post_data['email'] = $_POST['email'];
                } else {
                    $post_data['email'] = '';
                }
                
                $post_data['is_active'] = 1;
                $post_data['avatar'] = $this->common->do_upload_FBpicture($_POST['user_inid']);
                //$post_data['created'] = time();
                $post_data['created'] = date('Y-m-d H:i:s');
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                $post_data['is_verified'] = 1;
                $results = $this->api_model->create('users', $post_data);
                $insert_id = $this->db->insert_id();
                if ($results) {

                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
              //  $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
              //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
                
//                $del_address = $this->api_model->get_user_delivery_address($data['user_id']);
//                $data['delivery_address'] = $del_address;
                   // $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Instagram User Signup", NULL, NULL, "User created new account using facebook");
                
                } else {
                    $data['status'] = 0;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $insert_id = getVal('user_id', 'users', 'user_inid', $_POST['user_inid']);
                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
               // $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
                //$data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];

// $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Instagram User Signup", NULL, NULL, "User already have Instagram associated account, returning same account");
            }
        }
        
        else if ($_POST['user_twid'] <> '' && $_POST['user_twid'] <> 0) {
            $verify = $this->api_model->verify_user_twitter($_POST['user_twid']);
            if ($verify == 1) {
                $post_data['user_twid'] = $_POST['user_twid'];

                //$post_data['full_name'] = $_POST['full_name'];
                //$name = explode(' ', $_POST['full_name']);
                //$post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
                //$post_data['last_name'] = $name[1] <> '' ? $name[1] : '';
//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
                
                $post_data['name'] = $_POST['name'];
                
                if ($_POST['tw_img'] <> '') {
                    $post_data['avatar'] = $_POST['tw_img'];
                } 
                
                if ($_POST['email'] <> '') {
                    $post_data['email'] = $_POST['email'];
                } else {
                    $post_data['email'] = '';
                }
                
                $post_data['is_active'] = 1;
//                $post_data['avatar'] = $this->common->do_upload_FBpicture($_POST['user_fbId']);
                //$post_data['created'] = time();
                $post_data['created'] = date('Y-m-d H:i:s');
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                $post_data['is_verified'] = 1;
                $results = $this->api_model->create('user', $post_data);
                $insert_id = $this->db->insert_id();
                if ($results) {

                    $data = $this->api_model->get_user_data($insert_id);
                    unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                    $data['user_id']     = $data['user_id'];
                    $data['name']        = $data['name'];
                    $data['email']       = $data['email'];
                    $data['phone_no']    = $data['phone_no'];
                    $data['avatar']      = $data['avatar'];
                    $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
              //  $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
              //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
                
//                $del_address = $this->api_model->get_user_delivery_address($data['user_id']);
//                $data['delivery_address'] = $del_address;
                   // $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Twitter User Signup", NULL, NULL, "User created new account using twitter");
                } else {
                    $data['status'] = 1;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $insert_id = getVal('user_id', 'users', 'user_twid', $_POST['user_twid']);
                $data = $this->api_model->get_user_data($insert_id);
                unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                $data['user_id']     = $data['user_id'];
                $data['name']        = $data['name'];
                $data['email']       = $data['email'];
                $data['phone_no']    = $data['phone_no'];
                $data['avatar']      = $data['avatar'];
                $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
               // $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
              //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];

// $data['braintree'] = $this->api_model->get_braintree_data();
                $data['status'] = 1;
                $data['message'] = 'Congratulation! Your account has been created successfully.';
                $this->makeLog($insert_id, "Twitter User Signup", NULL, NULL, "User account associated with twitter already exist, returning same account.");
            }
        }
        
        
        
        
        else if ($_POST['email'] <> '' && $_POST['phone_no'] == '') {

            $verify = $this->api_model->verify_email($_POST['email']);
            if ($verify == 1) {

                $post_data['email'] = $_POST['email'];
                
//                $post_data['full_name'] = $_POST['full_name'];
//                $name = explode(' ', $_POST['full_name']);
//                $post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
//                $post_data['last_name'] = $name[1] <> '' ? $name[1] : '';
                
//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
//                
                $post_data['name'] = $_POST['name'];
                $post_data['username'] = $_POST['username'];
                $post_data['password'] = md5($_POST['password']);
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                
                $digits = 4;
                $post_data['pin'] = rand(pow(10, $digits-1), pow(10, $digits)-1);
                $post_data['is_active'] = 1;
                //$post_data['created'] = time();
                 $post_data['created'] = date('Y-m-d H:i:s');
                 $results = $this->api_model->create('users', $post_data);
                 $insert_id = $this->db->insert_id();
                 //$user_id = getVal('user_id', 'users', 'user_id', $insert_id);
                if ($results) {
                    
                    
                    
                       $email = $_POST['email'];
                        $e_data['receiver_name'] = $post_data['name'];
                        $e_data['email_content'] = "To verify your email address " . $email ." Please Click on the below link. 
                                <br /><br />
                                </b>Email verification Link: <b>". base_url()."home/email_verification/" .$this->common->encode($insert_id) . "</b>
                                <br /><br />
                                if you did not request this verification, please ignore this email. If you feel something is wrong, please contact our support team: admin@tagalong.com.
                                ";
                   
                 
                            $e_data['title'] = 'Verify Email Address';
                            $e_data['content'] = $data['email_content'];
                            $e_data['welcome_content'] = "Greetings ".$e_data['receiver_name'];
                            $e_data['footer'] = "Regards";
                            $subject = $e_data['title'];
                            $email_content = $this->load->view('includes/email_templates/email_template', $e_data, true);
                            $this->emailutility->send_email_user($email_content, $email, $subject);
                       
                        unset($e_data);
                    
                    
                    
                    

                    $data = $this->api_model->get_user_data($insert_id);
                    unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                    $data['name']        = $data['name'];
                    $data['email']       = $data['email'];
                    $data['phone_no']    = $data['phone_no'];
                    $data['avatar']      = $data['avatar'];
                    
                //  $data['location'] = $this->api_model->get_user_location($insert_id);
                
                //  $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
                //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
                // $data['braintree'] = $this->api_model->get_braintree_data();
                    //$data['status'] = 1;
                    //$data['message'] = 'Congratulation! Your account has been created successfully.';
                    //unset($data);
                    
                    $this->makeLog($insert_id, "User Email Signup", NULL, NULL, "User signup using email");
                    
                    $data['status'] = 1;
                    $data['user_id'] = $insert_id;
                    $data['is_verified'] = 0;
                    $data['message'] = 'Congratulation! Your account has been created successfully. Now please verify your email address by click the link sent to your email address.';
                    
                } else {
                    $data['status'] = 1;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $data['status'] = 0;
                $data['error'] = 202;
                $data['message'] = 'Email already exists. Please try another one.';
            }
        } else if ($_POST['email'] == '' && $_POST['phone_no'] <> '' ) {
           
           $verify = $this->api_model->verify_phone($_POST['phone_no']);
            
            if ($verify == 1) {

//                $post_data['full_name'] = $_POST['full_name'];
//                $name = explode(' ', $_POST['full_name']);
//                $post_data['first_name'] = $name[0] <> '' ? $name[0] : '';
//                $post_data['last_name'] = $name[1] <> '' ? $name[1] : '';

//                $post_data['first_name'] = $_POST['first_name'];
//                $post_data['last_name'] = $_POST['last_name'];
//                
                $post_data['name'] = $_POST['name'] ;
                $post_data['username'] = $_POST['username'];
                $post_data['phone_no'] = $_POST['phone_no'];
                $post_data['password'] = md5($_POST['password']);
                $post_data['email'] = '';
                $post_data['is_active'] = 1;
                $post_data['is_verified'] = 1;
                $post_data['secret_key'] = $this->common->uniqueKey(40, 8);
                //$post_data['created'] = time();
                $post_data['created'] = date('Y-m-d H:i:s');
                $results = $this->api_model->create('users', $post_data);
                $insert_id = $this->db->insert_id();
                if ($results) {

                    $data = $this->api_model->get_user_data($insert_id);
                    unset($data['fb_url'], $data['tw_url'], $data['soundcloud_url'],$data['web_url']);
                    $data['name']        = $data['name'];
                    $data['email']       = $data['email'];
                    $data['phone_no']    = $data['phone_no'];
                    $data['avatar']      = $data['avatar'];
                    $data['is_verified'] = $data['is_verified'];
//                $data['location'] = $this->api_model->get_user_location($insert_id);
                
               // $data['preferred_locations'] = $this->api_model->get_user_preferred_location($insert_id);
              //  $data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];

                
                    // $data['braintree'] = $this->api_model->get_braintree_data();
                    $data['status'] = 1;
                    $data['user_id'] =  $insert_id;
                    $data['message'] = 'Congratulation! Your account has been created successfully.';
                } else {
                    $data['status'] = 0;
                    $data['error'] = 201;
                    $data['message'] = 'Not able to register. Try again later.';
                }
            } else {
                $data['status'] = 0;
                $data['error'] = 202;
                $data['message'] = 'Phone Number already exists. Please try another one.';
            }
        } else {
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
        $this->api_model->create("activity_logs",$post_data);
    }
    
    
    function verifyUserPin() {
       $data = array();
       $post_data = array();
        if($_POST['user_id'] <> '' && $_POST['pin'] <> '' ){
            $user_id = $_POST['user_id'];
            $pin = $_POST['pin'];
            $check = $this->api_model->verifyUserPin($user_id,$pin);
            if($check == 0){
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Sorry, you have entered wrong pin code.';
                $this->makeLog($_POST['user_id'], "Verify email address", NULL, NULL, "User provided wrong PIN");
                header('Content-Type: application/json');
                echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
                exit;
            }
            else if ($check == -1) {
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            
            $cond = array();
            $cond['user_id'] = $user_id;
            $cond['pin'] = $pin;
            $post_data['is_verified'] = 1;
            $up = $this->api_model->update('users', $post_data, $cond);
            
           
            $data = array();
            $data = $this->api_model->get_user_data($user_id);
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
            
            //$data['preferred_locations'] = $this->api_model->get_user_preferred_location($user_id);
            //$data['preferred_locations']['street_address'] = '||'.$data['preferred_locations']['street_address'];
            
            
            
//            
//            
//            $data = $this->api_model->get_user_data($_POST['user_id']);
//            $data['phone_no'] = '||'.$data['phone_no'];
//            $data['date_of_birth'] = '||'.$data['date_of_birth'];
//            $data['gender'] = '||'.$data['gender'];
//            $data['is_verified'] = 1;
//            $data['city_name'] = getVal('name', 'city', 'id', $data['city_id']);
//            $data['country_name'] = getVal('name', 'country', 'id', $data['country_id']);
//            $data['preferred_locations'] = $this->api_model->get_user_preferred_location($_POST['user_id']);
//            $data['status'] = 1;
//            $data['user_id'] =  $_POST['user_id'];
            $data['message'] = 'Congratulation! Your account has been verified successfully.';
            $this->makeLog($_POST['user_id'], "Verify email address", NULL, NULL, "User successfully verifed email address");
               
//           
//            else{
//                $this->makeLog($_POST['user_id'], "Verify email address", NULL, NULL, "User provided wrong PIN");
//                $data['status'] = 0;
//                $data['error'] = 404;
//                $data['message'] = 'Sorry, you have entered wrong pin code.';
//            }
            
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
        
    }
    
    
    function resendEmailVerification(){
        $data = array();
        if($_POST['user_id']<>''){
            $checkStatus = $this->api_model->verify_user_id($_POST['user_id']);
            if($checkStatus == 1){
                 $user_id = $_POST['user_id'];
                 $data = $this->api_model->get_user_data($user_id);
                 $pin = getVal('pin', 'users', 'user_id', $user_id);
                 
                 
                       $email = $_POST['email'];
                        $e_data['receiver_name'] = $data['name'];
                        $e_data['email_content'] = "To verify your email address " . $email ." Please use the following PIN. 
                                <br /><br />
                                Verification PIN: <b>".$pin. "</b>
                                <br /><br />
                                if you did not request this verification, please ignore this email. If you feel something is wrong, please contact our support team: admin@gurupore.com.
                                ";
                   
                 
                            $e_data['title'] = 'Verify Email Address';
                            $e_data['content'] = $e_data['email_content'];
                            $e_data['welcome_content'] = "Greetings ".$e_data['receiver_name'];
                            $e_data['footer'] = "Regards";
                            $subject = $e_data['title'];
                            $email_content = $this->load->view('includes/email_templates/email_template', $e_data, true);
                            $this->emailutility->send_email_user($email_content, $email, $subject);
                       
                        unset($e_data);
                        unset($data);
                        
                $data['status'] = 1;
                $data['message'] = 'Verification email sent successfully.';
                $this->makeLog($_POST['user_id'], "Verification email resent", NULL, NULL, "Verification email sent to user again");
                
                 
            }
            else if ($checkStatus == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'No associated account found.';
            }
        
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }    
    
    
    
    function reportUser() {
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['target_id'] <> '' ){
            
            
            $this->exitIfInactive($_POST['target_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            
            
            
            if($this->api_model->verify_user_id($_POST['user_id']) == 1 && $this->api_model->verify_user_id($_POST['target_id']) == 1){
                $post_data = array();
                $post_data['user_id'] = $_POST['user_id'];
                $post_data['target_id'] = $_POST['target_id'];
                $post_data['comment'] = $_POST['comment'];
                $insert_id = $this->api_model->create("reported_users",$post_data);
                if ($insert_id > 0){
                    $data['status'] = 1;
                    $data['message'] = 'Thank you for your feedback. We will review your request shortly';
                     $this->makeLog($_POST['user_id'], "Report User", NULL, $_POST['target_id'], "User submitted report successfully");
               }
                else{
                    $data['status'] = 0;
                    $data['error'] = 402;
                    $data['message'] = 'Sorry failed to report user, Please try again later.';
                    $this->makeLog($_POST['user_id'], "Report User Failed", NULL, $_POST['target_id'], "Failed to report successfully");
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'No associated account found.';
                $this->makeLog($_POST['user_id'], "Report User Denied", NULL, $_POST['target_id'], "No associated account found");
               
            }
        
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
            
        }
        header('Content-Type: application/json');
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }
    
    
    function send_notification($registration_ids, $message, $notification_title, $notification_text, $user_id,$notificationFlag) {
       
        $badge = 0; $badge_message = 0;
        $notification['body'] = $notification_text;
        $notification['title'] = $notification_title;
        
        if ($notificationFlag == 1) {
            $badge = $this->api_model->getBadgeIncremented($user_id);
            $badge_message = getVal('message_badge', 'user', 'user_id', $user_id);
        }
        else if ($notificationFlag == 2) {
            $badge = getVal('badge', 'user', 'user_id', $user_id);
            $badge_message = $this->api_model->getMessageBadgeIncremented($user_id);
            $notification['sound'] = "default";
        }
        else if ($notificationFlag == 3){
            $badge = getVal('badge', 'user', 'user_id', $user_id);
            $badge_message = getVal('message_badge', 'user', 'user_id', $user_id);
            $notification['sound'] = "default";
        }
        
        
        
        $notification['badge'] = $badge + $badge_message;
        $message['badge'] = $badge + $badge_message;
        
        foreach ($registration_ids as $arr ){   
        $fields = array(
            'registration_ids' => array($arr),
            'data' => $message,
            'notification'=> $notification,
            'priority' => "high"
        );
        
        $headers = array(
            'Authorization: key=AAAA3MUYGbE:APA91bGbqw9-2nKrU3RcopRhFTaJlAnvfGuZlfH2gA3fH-IMn7ax1v1jyjSadMNud_zDb7O1jAeUD8Ddf3Gbpe2KvwI1kEADf2m_Qcj2ZxJHcAemhtx3Ekj9-_-yZRZlhnMai8lSPpso',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed:' . curl_errno($ch));
        }
        curl_close($ch);
//        echo "---------";
//        print_r($result);
    }
        //
       // exit;
  
    }
    
    
    function exitIfInactive($user_id){
        
       $is_inative = $this->api_model->isUserInactive($user_id);
        
        if ($is_inative == 1){
            $data['status'] = 0;
            $data['error'] = 204;
            $data['message'] = 'The user you are trying to access is inactive.';
            header('Content-Type: application/json');
            echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
            exit;
        }
    }
    
    
    function resetBadgeNumber($user_id) {
        $post_data = array();
        $cond_array = array(); 
        $post_data['badge'] = 0;
        $cond_array['user_id'] = $user_id;
        $up = $this->api_model->update('users', $post_data, $cond_array);
       
        
    }
    
    
    function getHomeData(){
        $data = array();
        $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        if($_GET['user_id'] <> '' ) {
            $this->exitIfInactive($_GET['user_id']);     
             $data['status'] = 1;
             $data['banner'] = $this->api_model->getBanner();
             $data['categories'] = $this->api_model->getCategories(0,10);
        
             $user_city_id = getVal('city_id', 'user', 'user_id', $_GET['user_id']);
             if($user_city_id == NULL || $user_city_id == '' || $user_city_id == 0){
                $data['featuredGurus'] = array();
                $data['featuredClasses'] = array();
                $data['graph_categories'] = $this->api_model->categoryGraph();
             }
             else{
                $data['featuredGurus'] = $this->api_model->getFeaturedGuruHome($_GET['user_id']);
                $data['featuredClasses'] = $this->api_model->getFeaturedClassHome($_GET['user_id']);
                $data['graph_categories'] = $this->api_model->categoryGraph();
            }
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
    
   function myGuruProfile (){
       $data = array();
       $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        if ($_GET['user_id'] <> ''){
            $this->exitIfInactive($_GET['user_id']);
            $data['status'] = 1;
            
            $data['skills'] = $this->api_model->getGuruSkills($_GET['user_id']);
            $data['classes'] = $this->api_model->getGuruHomeClasses($_GET['user_id']);
            $data['pending_private_class_count'] = $this->api_model->getGuruPrivateClassesCount($_GET['user_id']);
            $data['private_accepted_classes'] =  $this->api_model->getPrivateGuruAcceptedClasses($_GET['user_id']);
            $data['guru_average_rating'] = getVal('guru_average_rating', 'user', 'user_id', $_GET['user_id']);
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
   
   function acceptPrivateClass(){
        $data = array();
       $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if ($_POST['user_id'] <> '' && $_POST['student_id'] <> '' && $_POST['class_id'] <> '' ){
            
            $this->exitIfInactive($_POST['user_id']);
            $this->exitIfInactive($_POST['student_id']);
            
            $post_data = array();
            $post_data['is_approved'] = 1;
            $cond_array = array();
            $cond_array['guru_id'] = $_POST['user_id'];
            $cond_array['user_id'] = $_POST['student_id'];
            $cond_array['id'] = $_POST['class_id'];
            $up = $this->api_model->update('private_class', $post_data, $cond_array);
            
            if($up > 0) {
                
                                        
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['guru_id'] = $_POST['user_id'];
                        $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'private_class', 'id', $_POST['class_id']);
                        $desc = $message['guru_name']." has accepted your private ".$message['class_name']." request.";
                        $this->send_notification($regIds, $message,"Your Private class request has been accepted",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $_POST['student_id'];
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'privateClass';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                $this->makeLog($_POST['user_id'], "Accepted private class", $_POST['class_id'], $_POST['student_id'], "Guru user accepted private class");
                $data['status'] = 1;
                $data['message'] = 'Private class accepted.';
            }
            else{
                $this->makeLog($_POST['user_id'], "Failed accepting private class", $_POST['class_id'], $_POST['student_id'], "Guru user failed to accept private class");
                $data['status'] = 0;
                $data['message'] = 'Failed to accept private class.';
            }
                    
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
   
   
    function rejectPrivateClass(){
        $data = array();
       $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if ($_POST['user_id'] <> '' && $_POST['student_id'] <> '' && $_POST['class_id'] <> '' ){
            
            $this->exitIfInactive($_POST['user_id']);
            $this->exitIfInactive($_POST['student_id']);
            
            $cond_array = array();
            $cond_array['guru_id'] = $_POST['user_id'];
            $cond_array['user_id'] = $_POST['student_id'];
            $cond_array['id'] = $_POST['class_id'];
            $up = $this->api_model->delete('private_class', $cond_array);
            
            if($up > 0) {
//                private_class_schedule
                $cond_array = array();
                $cond_array['class_id'] = $_POST['class_id'];
                $up = $this->api_model->delete('private_class_schedule', $cond_array);
                if($up > 0 ){
                    
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['guru_id'] = $_POST['user_id'];
                        $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'private_class', 'id', $_POST['class_id']);
                        $desc = $message['guru_name']." has rejected your ".$message['class_name']." request.";
                        $this->send_notification($regIds, $message,"Your private class request has been rejected",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $_POST['student_id'];
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'nil';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                    
                   $this->makeLog($_POST['user_id'], "Rejected private class", $_POST['class_id'], $_POST['student_id'], "Guru user rejected private class");
                 
                    $data['status'] = 1;
                    $data['message'] = 'Private class rejected.';

                }
                else{
                    $this->makeLog($_POST['user_id'], "Failed to reject private class", $_POST['class_id'], $_POST['student_id'], "Guru user failed to reject private class");
                    $data['status'] = 0;
                    $data['message'] = 'Failed to reject private class.';
                }
            }
            else{
                $this->makeLog($_POST['user_id'], "Failed to reject private class", $_POST['class_id'], $_POST['student_id'], "Guru user failed to reject private class");
                    
                $data['status'] = 0;
                $data['message'] = 'Failed to reject private class.';
            }
                    
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
   
   
   function categoryGraph(){
       $data = array();
       $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
       if ($_POST['user_id'] <> ''){
           
          $data['status'] = 1;
          $data['categories'] = $this->api_model->categoryGraph();
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
   
//   function 
   
   function pendingGuruPrivateClasses (){
       $data = array();
       $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
       
       
        if ($_POST['user_id'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['private_classes'] = $this->api_model->getPrivateGuruPendingClasses($_POST['user_id'],$_POST['index'],$_POST['count']);
            
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

   
   
   
    
   
//   function get
    
    function getCategories(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' ){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['categories'] = $this->api_model->getCategories($_POST['index'],$_POST['count']);
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
    
    function getCategoryDetails(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['category_id']<>'' && $_POST['user_id']<>''){
            
            $this->exitIfInactive($_POST['user_id']);
            if($this->api_model->verifyCategory($_POST['category_id'])){
                $result = $this->api_model->getSubCategories($_POST['category_id']);
                if($result){
                    $data['status'] = 1;
                    $data['subCategories'] = $result;
                }
                else{
                   
                    $data['status'] = 1;
                    $data['gurus'] = $this->api_model->getCatGurus($_POST['category_id'],$_POST['user_id'],0,10);
                    $data['classes'] = $this->api_model->getCatClasses($_POST['category_id'],$_POST['user_id'],0,10);
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'No such category exist.';
            }
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
    
    function getGurus(){
         $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['category_id']<>'' && $_POST['user_id']<>''){
            
            $this->exitIfInactive($_POST['user_id']);
            if($this->api_model->verifyCategory($_POST['category_id'])){
//                index, count
                $data['status'] = 1;
                $data['gurus'] = $this->api_model->getCatGurus($_POST['category_id'],$_POST['user_id'],$_POST['index'],$_POST['count']);
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'No such category exist.';
            }
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
    
     function getClasses(){
         $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['category_id']<>'' && $_POST['user_id']<>''){
            
            $this->exitIfInactive($_POST['user_id']);
            if($this->api_model->verifyCategory($_POST['category_id'])){
//                index, count
                $data['status'] = 1;
                $data['classes'] = $this->api_model->getCatClasses($_POST['category_id'],$_POST['user_id'],$_POST['index'],$_POST['count']);
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'No such category exist.';
            }
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
    
    
    function likes(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            
           $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['gurus'] = $this->api_model->getLikedGurus($_POST['user_id'],$_POST['index'],$_POST['count']);
            $data['classes'] = $this->api_model->getLikedClasses($_POST['user_id'],$_POST['index'],$_POST['count']);
            
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
    
    function likedGurus(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            
            $this->exitIfInactive($_POST['user_id']);
            
            $data['status'] = 1;
            $data['gurus'] = $this->api_model->getLikedGurus($_POST['user_id'],$_POST['index'],$_POST['count']);
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
    
    function likedClasses()
    {
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
           
             
             $this->exitIfInactive($_POST['user_id']);
            
            $data['status'] = 1;
            $data['classes'] = $this->api_model->getLikedClasses($_POST['user_id'],$_POST['index'],$_POST['count']);
            
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

    
    function guruProfile(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>'' && $_POST['guru_id']<>''){
           
            
            $this->exitIfInactive($_POST['user_id']);
            $this->exitIfInactive($_POST['guru_id']);
           
            
            
            $data['status'] = 1;
            $data['guru'] = $this->api_model->getGuruProfile($_POST['user_id'],$_POST['guru_id']);
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

    
    function guruReviews(){
        $data = array();
        
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>'' && $_POST['guru_id']<>''){
            
            
            $this->exitIfInactive($_POST['guru_id']);
//            $this->exitIfInactive($_POST['user_id']);
            
            $data['status'] = 1;
            $data['reviews'] = $this->api_model->getGuruReviews($_POST['guru_id'],$_POST['index'],$_POST['count']);
            $data['average'] = getVal('guru_average_rating', 'user', 'user_id', $_POST['guru_id']);
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
    
    function guruRatingQuestions(){
        $data = array();
        $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        if($_GET['user_id']<>''){
            $this->exitIfInactive($_GET['user_id']);
            
            $data['status'] = 1;
            $data['questions'] = $this->api_model->guruRatingQuestions($_GET['user_id']);
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
    
    function studentRatingQuestions(){
        
        $data = array();
        $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        if($_GET['user_id']<>''){
            $this->exitIfInactive($_GET['user_id']);
            $data['status'] = 1;
            $data['questions'] = $this->api_model->studentRatingQuestions($_GET['user_id']);
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
    
    function rateUser(){
         $data = array();
//         $js = json_decode($_POST['jsonrate'],true);
//        echo $js[0]["rating"];
//        echo "----";
//        echo count($js);
//        exit;
         $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['rating'] <> ''  && $_POST['question_rating'] <> '' && ($_POST['guru_id'] <> '' || $_POST['student_id'] <> '' )){
            
            $this->exitIfInactive($_POST['user_id']);
            
            if ($_POST['guru_id'] <> ''){
                $this->exitIfInactive($_POST['guru_id']);
                $check = $this->api_model->ifAlreadyRatedGuru($_POST['user_id'],$_POST['guru_id']);
                $count = $this->api_model->getRatingCountGuru($_POST['guru_id']);
                if ($check >= 0) {
                    
                    
                    $post_data = array();
                    $post_data['rating'] = $_POST['rating'];
                    if ($_POST['comments']){
                        $post_data['note'] = $_POST['comments'];
                    }
                    $cond_array = array();
                    $cond_array['guru_id'] = $_POST['guru_id'];
                    $cond_array['user_id'] = $_POST['user_id'];
                    
                    $del = $this->api_model->delete('guru_question_based_rating', $cond_array);
                    if ($del > 0){
                        $js = json_decode($_POST['question_rating'],true);
                        for ($x = 0; $x < count($js); $x++){
                            $tmp = $js[$x]; 
                            $q_array['guru_id'] = $_POST['guru_id'];
                            $q_array['user_id'] = $_POST['user_id'];
                            $q_array['question_id'] = $tmp['qid'];
                            $q_array['rating'] = $tmp['rating'];
                            $this->api_model->create('guru_question_based_rating', $q_array);
                        }
                        
                        
                        
                    }
                     
                    
                    $up = $this->api_model->update('guru_rating', $post_data, $cond_array);
                    
                    if($up > 0){
                        $prev = getVal('guru_average_rating', 'user', 'user_id', $_POST['guru_id']);
                        $new_rating = (($count * $prev) + $_POST['rating'] - $check) / $count; 
                        $post_data = array();
                        $post_data['guru_average_rating'] = $new_rating;
                        $up = $this->api_model->update('user', $post_data, array('user_id' => $_POST['guru_id']));
                        if($up > 0 ){
                            $this->makeLog($_POST['user_id'], "User updated guru rating", NULL, $_POST['guru_id'], "User updated guru rating to ".$_POST['rating']);
                            $data['status'] = 1;
                            $data['rating'] = $new_rating;
                        }
                        else{
                            $this->makeLog($_POST['user_id'], "User failed updating guru rating", NULL, $_POST['guru_id'], "User failed to update guru rating to ".$_POST['rating']);
                            $data['status'] = 0;
                            $data['message'] = "Rating failed, Please try again";
                        }
                    }
                    else{
                        $this->makeLog($_POST['user_id'], "User failed updating guru rating", NULL, $_POST['guru_id'], "User failed to update guru rating to ".$_POST['rating']);
                        $data['status'] = 0;
                        $data['message'] = "Rating failed, Please try again";
                    }
                        
                }
                else if ($check == -1){
                    $post_data = array();
                    $post_data['guru_id'] = $_POST['guru_id'];
                    $post_data['user_id'] = $_POST['user_id'];
                    $post_data['rating'] = $_POST['rating'];
                    $post_data['note'] = $_POST['comments'];
                    $ins = $this->api_model->create('guru_rating', $post_data);
                    if($ins > 0){
                        
                        $up = 0;
                        $rating = 0.0;
                        $prev = getVal('guru_average_rating', 'user', 'user_id', $_POST['guru_id']);
                        $new_rating = (($count * $prev) + $_POST['rating']) / ($count+1);
                        $post_data = array();
                        $post_data['guru_average_rating'] = $new_rating;
                        $up = $this->api_model->update('user', $post_data, array('user_id' => $_POST['guru_id']));
                        $rating = $new_rating;
//                      
                        $js = json_decode($_POST['question_rating'],true);
                        for ($x = 0; $x < count($js); $x++){
                            $tmp = $js[$x]; 
                            $q_array['guru_id'] = $_POST['guru_id'];
                            $q_array['user_id'] = $_POST['user_id'];
                            $q_array['question_id'] = $tmp['qid'];
                            $q_array['rating'] = $tmp['rating'];
                            $this->api_model->create('guru_question_based_rating', $q_array);
                        }
                        
                        
                        if ($up > 0 ){
                            $this->makeLog($_POST['user_id'], "User rated guru", NULL, $_POST['guru_id'], "User gave guru rating ".$_POST['rating']);
                      
                            $data['status'] = 1;
                            $data['rating'] = $rating;
                        }
                        else{
                            $data['status'] = 0;
                            $data['message'] = "Rating failed, Please try again";
                            $this->makeLog($_POST['user_id'], "User failed to rate guru", NULL, $_POST['guru_id'], "User failed to rate guru ".$_POST['rating']);
                      
                            
                        }
                        
                    }
                    else{
                        $data['status'] = 0;
                        $data['message'] = "Rating failed, Please try again";
                        $this->makeLog($_POST['user_id'], "User failed to rate guru", NULL, $_POST['guru_id'], "User failed to rate guru ".$_POST['rating']);
                        
                    }
                    
                }
                
                if ($data['status'] == 1){
                        $to_id = $_POST['guru_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['user_id'] = $_POST['user_id'];
                        $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $desc = $message['user_name']." has rated you ".$_POST['rating'];
                        $this->send_notification($regIds, $message,"A student has rated you.",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $to_id;
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['action'] = 'ratingAsGuru';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                }
            }
            else if ($_POST['student_id'] <> '') {
                
                $this->exitIfInactive($_POST['student_id']);
                
                $check = $this->api_model->ifAlreadyRatedStudent($_POST['user_id'],$_POST['student_id']);
                $count = $this->api_model->getRatingCountStudent($_POST['student_id']);
                if ($check > 0) {
                    $post_data = array();
                    $post_data['rating'] = $_POST['rating'];
                    if ($_POST['comments']){
                        $post_data['note'] = $_POST['comments'];
                    }
                    $cond_array = array();
                    $cond_array['guru_id'] = $_POST['user_id'];
                    $cond_array['user_id'] = $_POST['student_id'];
                    
                    $del = $this->api_model->delete('user_question_based_rating', $cond_array);
                    if ($del > 0){
                        $js = json_decode($_POST['question_rating'],true);
                        for ($x = 0; $x < count($js); $x++){
                            $tmp = $js[$x]; 
                            $q_array['guru_id'] = $_POST['user_id'];
                            $q_array['user_id'] = $_POST['student_id'];
                            $q_array['question_id'] = $tmp['qid'];
                            $q_array['rating'] = $tmp['rating'];
                            $this->api_model->create('user_question_based_rating', $q_array);
                        }
                    }
                    
                    
                    $up = $this->api_model->update('user_rating', $post_data, $cond_array);
                    
                    if($up > 0){
                        $prev = getVal('user_average_rating', 'user', 'user_id', $_POST['student_id']);
                        $new_rating = (($count * $prev) + $_POST['rating'] - $check) / $count; 
                        $post_data = array();
                        $post_data['user_average_rating'] = $new_rating;
                        $up = $this->api_model->update('user', $post_data, array('user_id' => $_POST['student_id']));
                        if($up > 0 ){
                            $this->makeLog($_POST['user_id'], "Guru updated user rating", NULL, $_POST['student_id'], "Guru rated user ".$_POST['rating']);
                            $data['status'] = 1;
                            $data['rating'] = $new_rating;
                        }
                        else{
                            $data['status'] = 0;
                            $data['message'] = "Rating failed, Please try again";
                            $this->makeLog($_POST['user_id'], "Guru failed to updat user rating", NULL, $_POST['student_id'], "Guru failed to  update user rating");
                            
                        }
                    }
                    else{
                        $data['status'] = 0;
                        $data['message'] = "Rating failed, Please try again";
                        $this->makeLog($_POST['user_id'], "Guru failed to updat user rating", NULL, $_POST['student_id'], "Guru failed to  update user rating");
                        
                    }
                        
                }
                else if ($check == -1){
                    $post_data = array();
                    $post_data['guru_id'] = $_POST['user_id'];
                    $post_data['user_id'] = $_POST['student_id'];
                    $post_data['rating'] = $_POST['rating'];
                    $post_data['note'] = $_POST['comments'];
                    $ins = $this->api_model->create('user_rating', $post_data);
                    
                    $js = json_decode($_POST['question_rating'],true);
                        for ($x = 0; $x < count($js); $x++){
                            $tmp = $js[$x]; 
                            $q_array['guru_id'] = $_POST['user_id'];
                            $q_array['user_id'] = $_POST['student_id'];
                            $q_array['question_id'] = $tmp['qid'];
                            $q_array['rating'] = $tmp['rating'];
                            $this->api_model->create('user_question_based_rating', $q_array);
                        }
                    
                    
                    if($ins > 0){
                        $up = 0;
                        $rating = 0.0;
                        $prev = getVal('user_average_rating', 'user', 'user_id', $_POST['student_id']);
                        $new_rating = (($count * $prev) + $_POST['rating']) / ($count+1);
                        $post_data = array();
                        $post_data['user_average_rating'] = $new_rating;
                        $up = $this->api_model->update('user', $post_data, array('user_id' => $_POST['student_id']));
                        $rating = $new_rating;
                        
                        if ($up > 0 ){
                            $this->makeLog($_POST['user_id'], "Guru rated user", NULL, $_POST['student_id'], "Guru rated user ".$_POST['rating']);
                            $data['status'] = 1;
                            $data['rating'] = $rating;
                        }
                        else{
                            $this->makeLog($_POST['user_id'], "Guru failed to rate user", NULL, $_POST['student_id'], "Guru failed to rate user ".$_POST['rating']);
                            
                            $data['status'] = 0;
                            $data['message'] = "Rating failed, Please try again";
                        }
                        
                    }
                    else{
                        $this->makeLog($_POST['user_id'], "Guru failed to rate user", NULL, $_POST['student_id'], "Guru failed to rate user ".$_POST['rating']);
                            
                        $data['status'] = 0;
                        $data['message'] = "Rating failed, Please try again";
                    }
                    
                }
                
                if ($data['status'] == 1){
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['user_id'] = $_POST['user_id'];
                        $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $desc = $message['user_name']." has rated you ".$_POST['rating'];
                        $this->send_notification($regIds, $message,"A guru has rated you.",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $to_id;
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['action'] = 'ratingAsSeeker';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                }
            }
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
    
    
    function guruClasses(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['guru_id']<>'' && $_POST['user_id']<>'' && $_POST['category_id'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $this->exitIfInactive($_POST['guru_id']);
            
            $data['status'] = 1;
            $data['classes'] = $this->api_model->getGuruClasses($_POST['guru_id'],$_POST['user_id'],$_POST['index'],$_POST['count'],$_POST['category_id']);
            
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
    
    
    function getUserNotification(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            $this->resetBadgeNumber($_POST['user_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            $data['status'] = 1;
//            $data['notifications'] = $this->api_model->getUserNotification($_POST['user_id'],$_POST['index'],$_POST['count']);
            $data['notifications'] = $this->api_model->getUserNotification($_POST['user_id'],$_POST['index'],$_POST['count']);
//            echo 'yy';
//            $data['notifications'] = $this->timelapse($result);
//            echo 'zz';
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
    
    function timelapse($result){
//        echo 'here';
        for($x = 0; $x < count($result); $x++){
//            echo $x;
            $result[$x]['timestamp'] = $this->time_elapsed_string($result[$x]['timestamp'], true);
        }
//        echo 'not here';
        return $result;
    }
    
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    
    function myProfile(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['profile'] = $this->api_model->getMyProfile($_POST['user_id']);
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
    
    function asSeekerPastClasses(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            
            $data['status'] = 1;
            $data['past_classes'] = $this->api_model->getPastAsSeekerClasses($_POST['user_id']);
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
    
    function asGuruPastClasses(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>''){
            
            $data['status'] = 1;
            $data['past_classes'] = $this->api_model->getPastAsGuruClasses($_POST['user_id']);
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
    
    function studentReviews(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>'' && $_POST['student_id']<>''){
            
            $this->exitIfInactive($_POST['student_id']);
            $this->exitIfInactive($_POST['user_id']);        
            
            $data['status'] = 1;
            $data['ratings'] = $this->api_model->getRatingAsSeeker($_POST['student_id'],$_POST['index'],$_POST['count']);
            $data['average'] = getVal('user_average_rating', 'user', 'user_id', $_POST['student_id']);
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
    
   
    
    function likeGuru(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>'' && $_POST['guru_id']<>'' && $_POST['like']<>'' && $this->api_model->verifyGuru($_POST['guru_id'])){
            
            $this->exitIfInactive($_POST['guru_id']);
            $this->exitIfInactive($_POST['user_id']);
            $result = $this->api_model->isGuruAlreadyLiked($_POST['user_id'],$_POST['guru_id']);
            if($result == 1){
                if($_POST['like'] == 1){
                    $data['message'] = "Guru is already liked";
                    $this->makeLog($_POST['user_id'], 'Like guru', NULL, $_POST['guru_id'], "User has already liked guru");
                }
                else {
                     $guru_like = array();
                     $guru_like['guru_id'] = $_POST['guru_id'];
                     $guru_like['user_id'] = $_POST['user_id'];
                     $del = $this->api_model->delete('liked_guru', $guru_like);
                     if($del > 0){
                         
                        $this->makeLog($_POST['user_id'], 'Dislike guru', NULL, $_POST['guru_id'], "User has disliked guru");
                        $data['message'] = "Guru is disliked";
                     }
                     else{
                         $this->makeLog($_POST['user_id'], 'Failed to dislike guru', NULL, $_POST['guru_id'], "User has failed to dislike guru");
                         $data['message'] = "Guru can't be disliked at this moment";
                     }
                    
                }
            }
            else{
                if($_POST['like'] == 1){
                    $guru_like = array();
                    $guru_like['guru_id'] = $_POST['guru_id'];
                    $guru_like['user_id'] = $_POST['user_id'];
                    $ins = $this->api_model->create('liked_guru', $guru_like);
                    if($ins > 0){
                        
                        $to_id = $_POST['guru_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['user_id'] = $_POST['user_id'];
                        $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $desc = $message['user_name']." has liked you.";
                        $this->send_notification($regIds, $message,"A student has liked you.",$desc, $to_id,1);
                        
                        
                        $not_logs['user_id'] = $to_id;
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['action'] = 'student';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                        $this->makeLog($_POST['user_id'], 'Like guru', NULL, $_POST['guru_id'], "User has liked guru");
               
                        $data['message'] = "Guru is liked";
                     }
                     else{
                         $this->makeLog($_POST['user_id'], 'Failed to like guru', NULL, $_POST['guru_id'], "User failed to like  guru");
               
                         $data['message'] = "Guru can't be liked at this moment";
                     }
                }
                else {
                    $this->makeLog($_POST['user_id'], 'Failed to like guru', NULL, $_POST['guru_id'], "User failed to like  guru");
               
                    $data['message'] = "Guru is already not liked";
                }
            }
            $data['status'] = 1;
//            $data['ratings'] = $this->api_model->getRatingAsGuru($_POST['user_id'],$_POST['index'],$_POST['count']);
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
    
    
    
    function likeClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id']<>'' && $_POST['class_id']<>'' && $_POST['like']<>'' && $this->api_model->verifyClass($_POST['class_id'])){
            
            $guru_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
            $this->exitIfInactive($guru_id);
            $this->exitIfInactive($_POST['user_id']);
            
            $result = $this->api_model->isClassAlreadyLiked($_POST['user_id'],$_POST['class_id']);
            if($result == 1){
                if($_POST['like'] == 1){
                    $data['message'] = "Class is already liked";
                    $this->makeLog($_POST['user_id'], "Like Class", $_POST['class_id'], NULL, "User has already liked class");
                }
                else {
                     $class_like = array();
                     $class_like['class_id'] = $_POST['class_id'];
                     $class_like['user_id'] = $_POST['user_id'];
                     $del = $this->api_model->delete('liked_class', $class_like);
                     if($del > 0){
                     
                        $this->makeLog($_POST['user_id'], "Disliked class", $_POST['class_id'], NULL, "User has disliked class");
                        $data['message'] = "Class is disliked";
                     }
                     else{
                         $this->makeLog($_POST['user_id'], "Failed to dislike class", $_POST['class_id'], NULL, "User has failed to dislike class");
                         $data['message'] = "Class can't be disliked at this moment";
                     }
                    
                }
            }
            else{
                if($_POST['like'] == 1){
                    $class_like = array();
                    $class_like['class_id'] = $_POST['class_id'];
                    $class_like['user_id'] = $_POST['user_id'];
                    $ins = $this->api_model->create('liked_class', $class_like);
                    if($ins > 0){
                        
                        $to_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['user_id'] = $_POST['user_id'];
                        $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                        $desc = $message['user_name']." has liked your ".$message['class_name']." class.";
                        $this->send_notification($regIds, $message,"A student liked your class",$desc, $to_id,1);
                        
                        
                        $not_logs['user_id'] = $to_id;
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'student';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                     
                        $this->makeLog($_POST['user_id'], "Liked class", $_POST['class_id'], NULL, "User liked class");
                        $data['message'] = "Class is liked";
                     }
                     else{
                         $this->makeLog($_POST['user_id'], "Failed to like class", $_POST['class_id'], NULL, "User has failed to like class");
                         $data['message'] = "Class can't be liked at this moment";
                     }
                }
                else {
                    $this->makeLog($_POST['user_id'], "Failed to like class", $_POST['class_id'], NULL, "User has already not liked class");
                    $data['message'] = "Class is already not liked";
                }
            }
            $data['status'] = 1;
//            $data['ratings'] = $this->api_model->getRatingAsGuru($_POST['user_id'],$_POST['index'],$_POST['count']);
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
    
    
    function requestClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            if($this->api_model->verify_user_id($_POST['user_id'])){
                if($this->api_model->verifyClass($_POST['class_id'])){
                
                    
                $guru_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
            	$this->exitIfInactive($guru_id);
                $this->exitIfInactive($_POST['user_id']);
                    
                    
                    $verfy_check =$this->api_model->isUserAlreadyEnrolledRequested($_POST['user_id'],$_POST['class_id']);
                    if($verfy_check == 1){
                         $data['status'] = 0;
                         $data['message'] = 'You have already requested for this course';
                         $this->makeLog($_POST['user_id'], "Requested Class Denied", $_POST['class_id'], NULL, "User has already requested for this course");
                         header('Content-Type: application/json');
                         echo json_encode($data, JSON_NUMERIC_CHECK);
                         exit;
                    }
                    else if ($verfy_check == 2){
                        $data['status'] = 0;
                         $data['message'] = 'You are already enrolled in this class';
                         $this->makeLog($_POST['user_id'], "Requested Class Denied", $_POST['class_id'], NULL, "User is already enrolled for this course");
                         header('Content-Type: application/json');
                         echo json_encode($data, JSON_NUMERIC_CHECK);
                         exit;
                    }
                    
                    
                    $check_class_limit = $this->api_model->checkClassLimit($_POST['class_id']);
                    if($check_class_limit == 1){
                        $check_joining_date = $this->api_model->checkJoiningDate($_POST['class_id']);
                        if($check_joining_date == 1){
                            $class = array();
                            $class['class_id'] = $_POST['class_id'];
                            $class['user_id'] = $_POST['user_id'];
                            $class['is_approved'] = 0;
                            $ins = $this->api_model->create('class_member', $class);
                            if($ins>0){
                                
                                 $to_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);;
                                 $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                                 $message = array();
                                 $message['class_id'] = $_POST['class_id'];
                                 $message['user_id'] = $_POST['user_id'];
                                 $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                                 $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                                 $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                                 $desc = $message['user_name']." has sent you ".$message['class_name']." request.";
                                 $this->send_notification($regIds, $message,"A student has sent you class request.",$desc,$to_id,1);
                        
                        
                                 $not_logs['user_id'] = $to_id;
                                 $not_logs['sender_id'] = $_POST['user_id'];
                                 $not_logs['class_id'] = $_POST['class_id'];
                                 $not_logs['action'] = 'classRequest';
                                 $not_logs['description'] = $desc;
                                 $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                                
                                
                                $data['status'] = 1;
                                $data['user_req_status'] = 0;
                                $data['message'] = 'Your request has been sent.';
                                $this->api_model->updateClassRequest($_POST['class_id']);
                                
                                 $this->makeLog($_POST['user_id'], "Requested Class", $_POST['class_id'], NULL, "User has successfully requested for class");
                        
                            }
                            else{
                                $data['status'] = 0;
                                $data['error'] = 404;
                                $data['message'] = 'Sorry your request failed.';
                            }
                        }
                        else{
                            $data['status'] = 0;
                            $data['error'] = 404;
                            $this->makeLog($_POST['user_id'], "Requested Class Denied", $_POST['class_id'], NULL, "Joining date for the class has passed");
                            $data['message'] = 'Sorry joining date for the class has passed.';
                        }
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Requested Class Denied", $_POST['class_id'], NULL, "Class limit has reached");
                        $data['message'] = 'Sorry class limit is reached.';
                    }
                }
                else{
                    $data['status'] = 0;
                    $data['error'] = 404;
                    $this->makeLog($_POST['user_id'], "Requested Class Denied", $_POST['class_id'], NULL, "Class can not be verified");
                    $data['message'] = 'Class can not be verified.';
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'User can not be verified.';
            }
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
    
    
    function getClassRequestStatus(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['student_id'] <> '' && $_POST['class_id']){
                
            $this->exitIfInactive($_POST['student_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            $reqStatus = $this->api_model->verifyClassRequest($_POST['student_id'],$_POST['class_id']);
            if ($reqStatus == -1) {   
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Sorry unable to find class request.';
            }
            else{
                $data = $this->api_model->get_student_data($_POST['student_id']);
                $data['req_status'] = $reqStatus;
                $data['phone_no'] = '||'.$data['phone_no'];
                $data['date_of_birth'] = '||'.$data['date_of_birth'];
                $data['gender'] = '||'.$data['gender'];
                $data['city_name'] = getVal('name', 'city', 'id', $data['city_id']);
                $data['country_name'] = getVal('name', 'country', 'id', $data['country_id']);
                $data['status'] = 1;
            }
            
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
    
    
    function cancelRequestClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            if($this->api_model->verify_user_id($_POST['user_id'])){
                if($this->api_model->verifyClass($_POST['class_id'])){
                    
                    $guru_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
                    $this->exitIfInactive($guru_id);
                    $this->exitIfInactive($_POST['user_id']);
              
                    $result = $this->api_model->cancelClassRequest($_POST['user_id'],$_POST['class_id']);
                    if($result == 1){
                        
                        
                        $data['status'] = 1;
                        $data['user_req_status'] = 2;
                        $data['message'] = 'Your request has been cancelled.';
                        $this->makeLog($_POST['user_id'], "Cancel Class Request", $_POST['class_id'], NULL, "User has cancelled class request successfully");
                        
                        
                    }
                    else if ($result == 2){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Cancel Class Request Denied" , $_POST['class_id'], NULL, "User has already been enrolled in class");
                        
                        $data['message'] = 'Sorry, you have been already enrolled in this class.';
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Cancel Class Request Denied", $_POST['class_id'], NULL, "User request wasn't found");
                        
                        $data['message'] = 'Sorry, you do not have this class request.';
                    }
                    
                }
                else{
                    $data['status'] = 0;
                    $data['error'] = 404;
                    $data['message'] = 'Class can not be verified.';
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'User can not be verified.';
            }
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
    
    
    function acceptClassRequest(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['student_id'] <> '' && $_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            
            $this->exitIfInactive($_POST['student_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            if($this->api_model->verify_guru_class($_POST['user_id'],$_POST['class_id']) == 1){
                $result = $this->api_model->acceptClassRequest($_POST['student_id'],$_POST['class_id']);
                    if($result == 1){
                        
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['guru_id'] = $_POST['user_id'];
                        $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                        $desc = $message['guru_name']." has accepted your ".$message['class_name']." request.";
                        $this->send_notification($regIds, $message,"Your class request has been accepted",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $_POST['student_id'];
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'class';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                        
                        $data['status'] = 1;
                        $data['message'] = 'Class request has been accepted.';
                        $this->makeLog($_POST['user_id'], "Accept Class Request", $_POST['class_id'], $_POST['student_id'], "Guru has accepted user class request");
                        
                    }
                    else if ($result == 2){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Accept Class Request Denied", $_POST['class_id'], $_POST['student_id'], "Guru has already accepted user class request");
                        $data['message'] = 'Sorry, you have already accepted this class request.';
                    }
                    else if ($result == 3){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Accept Class Request Denied", $_POST['class_id'], $_POST['student_id'], "Guru has reached class limit");
                        $data['message'] = 'Sorry, you have reached class limit.';
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $this->makeLog($_POST['user_id'], "Accept Class Request Denied", $_POST['class_id'], $_POST['student_id'], "Class request couldn't be found");
                        $data['message'] = 'Sorry, you do not have this class request.';
                    }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Sorry you are not guru of this class.';
            }
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

    
    
    function removeStudent(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['student_id'] <> '' && $_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            
            $this->exitIfInactive($_POST['student_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            if($this->api_model->verify_guru_class($_POST['user_id'],$_POST['class_id']) == 1){
                $result = $this->api_model->removeStudent($_POST['student_id'],$_POST['class_id']);
                    if($result == 1){
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['guru_id'] = $_POST['user_id'];
                        $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                        $desc = $message['guru_name']." has removed you from ".$message['class_name'].".";
                        $this->send_notification($regIds, $message,"You have been removed from class.",$desc,$to_id,1);
                        
                        
                        $not_logs['user_id'] = $_POST['student_id'];
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'class';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                        
                        $data['status'] = 1;
                        $data['message'] = 'Student has been removed.';
                        
                        $this->makeLog($_POST['user_id'], "Remove Student", $_POST['class_id'], $_POST['student_id'], "Guru has removed student");                    }
                    else if ($result == 2){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, student is not a member of this class.';
                        $this->makeLog($_POST['user_id'], "Remove Student Denied", $_POST['class_id'], $_POST['student_id'], "Student is not enrolled in this class");
                        
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, you can not remove this student.';
                    }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Sorry you are not guru of this class.';
            }
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
    
    
    function rejectClassRequest(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
         if($_POST['student_id'] <> '' && $_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
             
             $this->exitIfInactive($_POST['student_id']);
             $this->exitIfInactive($_POST['user_id']);
             
            if($this->api_model->verify_guru_class($_POST['user_id'],$_POST['class_id']) == 1){
                $result = $this->api_model->rejectClassRequest($_POST['student_id'],$_POST['class_id']);
                    if($result == 1){
                        
                        $to_id = $_POST['student_id'];
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['guru_id'] = $_POST['user_id'];
                        $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                        $desc = $message['guru_name']." has rejected your ".$message['class_name']." request.";
                        $this->send_notification($regIds, $message,"Your class request has been rejected",$desc, $to_id,1);
                        
                        
                        $not_logs['user_id'] = $_POST['student_id'];
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'class';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                        
                        $data['status'] = 1;
                        $data['message'] = 'Student request has been rejected.';
                        $this->makeLog($_POST['user_id'], "Reject Class Request", $_POST['class_id'], $_POST['student_id'], "Guru has rejected student request");
                        
                    }
                    else if ($result == 2){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, student is already enrolled in the class.';
                        $this->makeLog($_POST['user_id'], "Reject Class Request Denied", $_POST['class_id'], $_POST['student_id'], "Student is already enrolled in class");
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, you can not delete student request.';
                    }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'Sorry you are not guru of this class.';
            }
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
       
    
    function leaveClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            if($this->api_model->verify_user_id($_POST['user_id'])){
                if($this->api_model->verifyClass($_POST['class_id'])){
                    
                $guru_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
            	$this->exitIfInactive($guru_id);
                $this->exitIfInactive(user_id);
                    
                    $result = $this->api_model->leaveClass($_POST['user_id'],$_POST['class_id']);
                    if($result == 1){
                        
                        $to_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);;
                        $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                        $message = array();
                        $message['class_id'] = $_POST['class_id'];
                        $message['user_id'] = $_POST['user_id'];
                        $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                        $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                        $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
                        $desc = $message['user_name']." has left your ".$message['class_name']." class.";
                        $this->send_notification($regIds, $message,"A student left your class.",$desc, $to_id,1);
                        
                        
                        $not_logs['user_id'] = $to_id;
                        $not_logs['sender_id'] = $_POST['user_id'];
                        $not_logs['class_id'] = $_POST['class_id'];
                        $not_logs['action'] = 'student';
                        $not_logs['description'] = $desc;
                        $insert = $this->api_model->create('notifications_logs', $not_logs);
                        
                        
                        $data['status'] = 1;
                        $data['user_req_status'] = 2;
                        $data['message'] = 'You have left the class.';
                        
                        $this->makeLog($_POST['user_id'], "Leave Class", $_POST['class_id'], NULL, "Student has left class");
                    }
                    else if ($result == 2){
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, you are not member of this class.';
                        $this->makeLog($_POST['user_id'], "Leave Class Denied", $_POST['class_id'], NULL, "User is not enrolled in class");
                    }
                    else{
                        $data['status'] = 0;
                        $data['error'] = 404;
                        $data['message'] = 'Sorry, you are not enrolled in this class.';
                        $this->makeLog($_POST['user_id'], "Leave Class Denied", $_POST['class_id'], NULL, "User is not enrolled in class");
                    
                    }
                    
                }
                else{
                    $data['status'] = 0;
                    $data['error'] = 404;
                    $data['message'] = 'Class can not be verified.';
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 404;
                $data['message'] = 'User can not be verified.';
            }
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
    
    function getClassStudents(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
                
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['approved_students'] = $this->api_model->getClassApprovedStudents($_POST['class_id']);
            $data['pending_students'] = $this->api_model->getClassPendingStudents($_POST['class_id']);
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
    
    function studentDetails(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['student_id'] <> ''){
                
            $this->exitIfInactive($_POST['student_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            $data = $this->api_model->get_student_data($_POST['student_id']);
            $data['phone_no'] = '||'.$data['phone_no'];
                
            $data['date_of_birth'] = '||'.$data['date_of_birth'];
            $data['gender'] = '||'.$data['gender'];
            $data['city_name'] = getVal('name', 'city', 'id', $data['city_id']);
            $data['country_name'] = getVal('name', 'country', 'id', $data['country_id']);
            $data['status'] = 1;
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
    

    
    function skills(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['guru_id'] <> ''){
                
            $this->exitIfInactive($_POST['guru_id']);
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['skills'] = $this->api_model->getGuruSkills($_POST['guru_id']);
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
    
    function skillDetails(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['skill_id'] <> '' && $_POST['user_id'] <> ''){
            
            $guru_id = getVal('guru_id', 'guru_skill', 'id', $_POST['skill_id']);
            $this->exitIfInactive($guru_id);
            
            $this->exitIfInactive($_POST['user_id']);
            
            
            $data['status'] = 1;
            $data['skill'] = $this->api_model->getSkillDetail($_POST['skill_id']);
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

    
    function addSkill(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $this->api_model->verify_user_id($_POST['user_id']) &&
                $this->api_model->verify_category($_POST['category_id'])){
            
            $this->exitIfInactive($_POST['user_id']);
            
            if ($this->api_model->skillAlreadyAdded($_POST['user_id'],$_POST['category_id'])){
                $data['status'] = 0;
                $data['message'] = "Skill already added";
                header('Content-Type: application/json');
                echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
                exit;
            }
            
            $post = array();
            $post['guru_id'] = $_POST['user_id'];
            $post['category_id'] = $_POST['category_id'];
            if($_POST['level'])
            $post['level'] = $_POST['level'];
            if($_POST['qualification'])
            $post['qualification'] = $_POST['qualification'];
            if($_POST['description'])
            $post['description'] = $_POST['description'];
            $insert = $this->api_model->create('guru_skill', $post);
            if($insert>0){
                $post_data =array();
                $post_data['is_guru'] = 1;
                $this->api_model->update('user', $post_data, array('user_id' => $_POST['user_id']));
                $data['status'] = 1;
                $data['skills'] = $this->api_model->getGuruSkills($_POST['user_id']);
            
                $this->makeLog($_POST['user_id'], "Add Skill", NULL, NULL, "User has added skill");
                    
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'Failed to add skill.';
                $this->makeLog($_POST['user_id'], "Add Skill Denied", NULL, NULL, "Failed to add skill");
                
            }
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
    
    function updateSkill(){
         $data = array();
         $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
         if($_POST['user_id'] <>'' && $_POST['skill_id']<>''){ 
             
             $this->exitIfInactive($_POST['user_id']);
             
             $post_data = array();
             if($_POST['category_id'])
             $post_data['category_id'] = $_POST['category_id'];
             if($_POST['level'])
             $post_data['level'] = $_POST['level'];
             if($_POST['qualification'])
             $post_data['qualification'] = $_POST['qualification'];
             if($_POST['description'])
             $post_data['description'] = $_POST['description'];
             
             $cond = array();
             $cond['id'] = $_POST['skill_id'];
             $cond['guru_id'] = $_POST['user_id'];
             
             $update = $this->api_model->update('guru_skill', $post_data, $cond);
             
             if($update>0){
                 $data['status'] = 1;
                 $data['message'] = 'Skill successfully updated.';
                 $this->makeLog($_POST['user_id'], "Update Skill", NULL, NULL, "User has updated skill");
                
             }
             else{
                 $data['status'] = 0;
                 $data['message'] = 'Failed to update skill.';
                 $this->makeLog($_POST['user_id'], "Update Skill Denied", NULL, NULL, "Failed to update skill");
                
             }
         
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
    
    
    
    
    /**
     * Method: AddAchievement
     * params: Posted Data $post
     * Return: Json
     */
    function addAchievement() {
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        $post_data = array();
        if ($_POST['user_id'] <> '' && $_POST['skill_id'] <>'') {
            
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if ($verify == 1) {
                $user_id = $_POST['user_id'];
                if ($_FILES['certificate']['name'] != '') {
                    
                    $extension = $this->common->getExtension($_FILES ['certificate'] ['name']);
                    $extension = strtolower($extension);
                    if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                        return false;
                    }
                    $path = 'uploads/users/skills/achievement';
                    $allow_types = 'gif|jpg|jpeg|png';
                    $max_height = '8000';
                    $max_width = '8000';
                    $avatar = $this->common->do_upload_profile($path, $allow_types, $max_height, $max_width, $_FILES ['certificate']['tmp_name'], $_FILES ['certificate']['name']);
                }
                $post_data['url'] = $photo = base_url('uploads/users/skills/achievement/' . $avatar);
                $post_data['skill_id'] = $_POST['skill_id'];
                $post_data['guru_id'] = $_POST['user_id'];
                $results = $this->api_model->create('achievement', $post_data);

                if ($results) {
                    $data['status'] = 1;
                    if ($avatar <> '') {
                        $data['achiemvent_id'] = $results;
                        $data['url'] = $photo;
                        $this->makeLog($_POST['user_id'], "Add Achievement", NULL, NULL, "User has added achievement");
                
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = 'Achivement not uploaded. Please try again later.';
                    $this->makeLog($_POST['user_id'], "Add Achievement Denied", NULL, NULL, "Uploading user achievement failed");
                
                }
            } 
            
            else if($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    
    function removeAchievement(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' && $_POST['skill_id'] <>'' && $_POST['achievement_id']) {
            
            $this->exitIfInactive($_POST['user_id']);
            $cond =array();
            $cond['id'] = $_POST['achievement_id'];
            $cond['guru_id'] = $_POST['user_id'];
            $cond['skill_id'] = $_POST['skill_id'];
            
            $result = $this->api_model->delete('achievement', $cond);
                if($result){
                    $data['status'] = 1;
                    $this->makeLog($_POST['user_id'], "Remove Achievement",NULL, NULL, "User has removed achievement");
                    $data['message'] = "successfully removed achivement";
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Failed to remove achivement.';
                    $this->makeLog($_POST['user_id'], "Remove Achievement Denied",NULL, NULL, "Failed to removed achievement");
                    
                }    
            
            
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function removeSkill(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' && $_POST['skill_id'] <>'' ) {
            
            $this->exitIfInactive($_POST['user_id']);
             $cond =array();
            $cond['guru_id'] = $_POST['user_id'];
            $cond['id'] = $_POST['skill_id'];
            
            $result = $this->api_model->delete('guru_skill', $cond);
                if($result){
                    $data['status'] = 1;
                    $data['skills'] = $this->api_model->getGuruSkills($_POST['user_id']);
                    $data['message'] = "successfully removed skill";
                    $this->makeLog($_POST['user_id'], "Remove Skill", NULL,NULL, "User has removed skill");
                     
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Failed to remove skill.';
                    $this->makeLog($_POST['user_id'], "Remove Skill Denied",NULL ,NULL, "Failed to remove skill");
                    
                }  
        
    
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }



    function createClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' && $_POST['category_id']<> '' && $_POST['class_name'] <> ''){
//            latitude,longitude,city_id,country_id,street_address,post_code
            
            
            $this->exitIfInactive($_POST['user_id']);
           
            $post_location = array();        
            $post_location['latitude'] = $_POST['latitude'];
            $post_location['longitude'] = $_POST['longitude'];
            $post_location['city_id'] = $_POST['city_id'];
            $post_location['country_id'] = $_POST['country_id'];
            $post_location['street_address'] = $_POST['street_address'];
            $post_location['post_code'] = $_POST['post_code'];
            $location_id = $this->api_model->create('location',$post_location);
            
            $post_class = array();
            $post_class['guru_id'] = $_POST['user_id'];
            $post_class['category_id'] = $_POST['category_id'];
            $post_class['name'] = $_POST['class_name'];
            $post_class['class_limit'] = $_POST['class_limit'];
            $post_class['last_joining_date'] = $_POST['last_joining_date'];
            $post_class['start_date'] = $_POST['start_date'];
            $post_class['end_date'] = $_POST['end_date'];
            $post_class['location_id'] = $location_id;
            
            $class_id = $this->api_model->create('class',$post_class);
            
            $post_sch = array();
            $post_sch['class_id'] = $class_id;
            $post_sch['start_time'] = $_POST['start_time'];
            $post_sch['end_time'] = $_POST['end_time'];
            $repeat = $_POST['repeat'];
            $repeat = explode(",", $repeat);
            for($x=0; $x < count($repeat); $x++){
                if(strpos($repeat[$x], '0') !== false){
                    $post_sch['sunday'] = 1;
                }
                else if(strpos($repeat[$x], '1') !== false){
                    $post_sch['monday'] = 1;
                }
                else if(strpos($repeat[$x], '2') !== false){
                    $post_sch['tuesday'] = 1;
                }
                else if(strpos($repeat[$x], '3') !== false){
                    $post_sch['wednesday'] = 1;
                }
                else if(strpos($repeat[$x], '4') !== false){
                    $post_sch['thursday'] = 1;
                }
                else if(strpos($repeat[$x], '5') !== false){
                    $post_sch['friday'] = 1;
                }
                else if(strpos($repeat[$x], '6') !== false){
                    $post_sch['saturday'] = 1;
                }
            }
            
            $schdual_id = $this->api_model->create('class_schedule',$post_sch);
          
            if($location_id>0 && $class_id >0 && $schdual_id>0){
                 $data['status'] = 1;
                 $data['classes'] = $this->api_model->getGuruClasses($_POST['user_id'],'',0,10,$_POST['category_id']);
                 $this->makeLog($_POST['user_id'], "Create Class",$class_id ,NULL, "User has created class");
                    
            }
            else{
                 $data['status'] = 0;
                 $data['message'] = 'Can not create class.';
            }
           
            
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function requestPrivateClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> ''){
            $post_class = array();
            
            $this->exitIfInactive($_POST['guru_id']);
            $this->exitIfInactive($_POST['user_id']);
            
            $post_class['user_id'] = $_POST['user_id'];
            $post_class['guru_id'] = $_POST['guru_id'];
            $post_class['category_id'] = $_POST['category_id'];
            $post_class['name'] = $_POST['class_name'];
            $post_class['start_date'] = $_POST['start_date'];
            $post_class['end_date'] = $_POST['end_date'];
            $post_class['address']  = $_POST['address'];
            
            $class_id = $this->api_model->create('private_class',$post_class);
            
//            private_class_schedule
            
            $post_sch = array();
            $post_sch['class_id'] = $class_id;
            $post_sch['start_time'] = $_POST['start_time'];
            $post_sch['end_time'] = $_POST['end_time'];
            $repeat = $_POST['repeat'];
            $repeat = explode(",", $repeat);
            for($x=0; $x < count($repeat); $x++){
                if(strpos($repeat[$x], '0') !== false){
                    $post_sch['sunday'] = 1;
                }
                else if(strpos($repeat[$x], '1') !== false){
                    $post_sch['monday'] = 1;
                }
                else if(strpos($repeat[$x], '2') !== false){
                    $post_sch['tuesday'] = 1;
                }
                else if(strpos($repeat[$x], '3') !== false){
                    $post_sch['wednesday'] = 1;
                }
                else if(strpos($repeat[$x], '4') !== false){
                    $post_sch['thursday'] = 1;
                }
                else if(strpos($repeat[$x], '5') !== false){
                    $post_sch['friday'] = 1;
                }
                else if(strpos($repeat[$x], '6') !== false){
                    $post_sch['saturday'] = 1;
                }
            }
            
            $schdual_id = $this->api_model->create('private_class_schedule',$post_sch);
//            category_color,category_icon, category_name
            if($class_id >0 && $schdual_id>0){
               
                $to_id = $_POST['guru_id'];
                $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                $message = array();
                $message['class_id'] = $class_id;
                $message['user_id'] = $_POST['user_id'];
                $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                $message['class_name'] = $_POST['class_name'];
                $desc = $message['user_name']." has requested you private ".$message['class_name']." request.";
                $this->send_notification($regIds, $message,"You have a private class request",$desc, $to_id,1);
                        
                        
                $not_logs['user_id'] = $to_id;
                $not_logs['sender_id'] = $_POST['user_id'];
                $not_logs['class_id'] = $class_id;
                $not_logs['action'] = 'privateClass';
                $not_logs['description'] = $desc;
                $insert = $this->api_model->create('notifications_logs', $not_logs);
                         
                $this->makeLog($_POST['user_id'], "Request Private Class", $class_id,NULL, "User has created class");
                 
                
                $data['status'] = 1;
                 $data['class_id'] = $class_id;
                 $data['title'] = $_POST['class_name'];
                 $data['user_req_status'] = 0;
                 $data['category_color'] = getVal('bg_color', 'category', 'id', $_POST['category_id']);
                 $data['category_icon'] = getVal('icon', 'category', 'id', $_POST['category_id']);
                 $data['category_name'] = getVal('name', 'category', 'id', $_POST['category_id']);
                
            }
            else{
                 $data['status'] = 0;
                 $data['message'] = 'Can not create class.';
                 $this->makeLog($_POST['user_id'], "Request Private Class Denied",NULL, NULL, "Failed to request private class");
                
            }
            
            
            
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
            
    function classDetails(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            
            $guru_id = getVal('guru_id', 'class', 'id', $_POST['class_id']);
            $this->exitIfInactive($guru_id);
            
            $this->exitIfInactive($_POST['user_id']);
            
//            echo'33333';
            if($this->api_model->verifyClass($_POST['class_id'])){
//                 echo'444444';
                if($this->api_model->verify_user_id($_POST['user_id']) == 1){
//                     echo'55555';
                    $data['status'] = 1;
                    $data['class'] = $this->api_model->getClassDetail($_POST['user_id'],$_POST['class_id']);
                    $data['class']['street_address'] = '||'.$data['class']['street_address'];
                }
               
                else{
                    $data['status'] = 0;
                    $data['error'] = 402;
                    $data['message'] = 'User not exist.';
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'Class not exist.';
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
//        echo json_encode($data, JSON_NUMERIC_CHECK);
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }
    
//    function getGuruPrivate
    
    function privateClassDetail(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            
            
            $guru_id = getVal('guru_id', 'private_class', 'id', $_POST['class_id']);
            
            $this->exitIfInactive($guru_id);
           
            $this->exitIfInactive($_POST['user_id']);
            
//            echo'33333';
            if($this->api_model->verifyPrivateClass($_POST['class_id'])){
//                 echo'444444';
                if($this->api_model->verify_user_id($_POST['user_id']) == 1){
//                     echo'55555';
                    $data['status'] = 1;
                    $data['class'] = $this->api_model->getPrivateClassDetail($_POST['user_id'],$_POST['class_id']);
                    $data['class']['address'] = '||'.$data['class']['address'];
                    
                }
                else{
                    $data['status'] = 0;
                    $data['error'] = 402;
                    $data['message'] = 'User not exist.';
                }
            }
            else{
                $data['status'] = 0;
                $data['error'] = 403;
                $data['message'] = 'Class not exist.';
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
//        echo json_encode($data, JSON_NUMERIC_CHECK);
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }
    
    
    function updateClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            
            $post_data = array();
            if($_POST['category_id']){
                $post_data['category_id'] = $_POST['category_id'];
            }
            if($_POST['class_name']){
                $post_data['name'] = $_POST['class_name'];
            }
            if($_POST['class_limit']){
                $post_data['class_limit'] = $_POST['class_limit'];
            }
            if($_POST['last_joining_date']){
                $post_data['last_joining_date'] = $_POST['last_joining_date'];
            }
            if($_POST['start_date']){
                $post_data['start_date'] = $_POST['start_date'];
            }
            if($_POST['end_date']){
                $post_data['end_date'] = $_POST['end_date'];
            }
            
            $cond = array();
            $cond['id'] = $_POST['class_id'];
            $cond['guru_id'] = $_POST['user_id'];
             
            $update = $this->api_model->update('class', $post_data, $cond);
            
            unset($post_data);
            $post_data = array();
            unset($cond);
            $cond = array();
            
            if($_POST['latitude']){
                $post_data['latitude'] = $_POST['latitude'];
            }
            if($_POST['longitude']){
                $post_data['longitude'] = $_POST['longitude'];
            }
            if($_POST['city_id']){
                $post_data['city_id'] = $_POST['city_id'];
            }
            if($_POST['country_id']){
                $post_data['country_id'] = $_POST['country_id'];
            }
            if($_POST['street_address']){
                $post_data['street_address'] = $_POST['street_address'];
            }
            if($_POST['post_code']){
                $post_data['post_code'] = $_POST['post_code'];
            }
            
//            location_id
            $cond['location_id'] = getVal('location_id', 'class', 'id', $_POST['class_id']);
            
            $update = $this->api_model->update('location', $post_data, $cond);
            
            unset($post_data);
            $post_data = array();
            unset($cond);
            $cond = array();
            
            if($_POST['start_time']){
                $post_data['start_time'] = $_POST['start_time'];
            }
            if($_POST['end_time']){
                $post_data['end_time'] = $_POST['end_time'];
            }
            $repeat_array = array();
            
            if($_POST['repeat']){
                $post_data['sunday'] = 0;
                $post_data['monday'] = 0;
                $post_data['tuesday'] = 0;
                $post_data['wednesday'] = 0;
                $post_data['thursday'] = 0;
                $post_data['friday'] = 0;
                $post_data['saturday'] = 0;
                
                $repeat = $_POST['repeat'];
                $repeat = explode(",", $repeat);
                for($x=0; $x < count($repeat); $x++){
                if(strpos($repeat[$x], '0') !== false){
                    $post_data['sunday'] = 1;
                }
                else if(strpos($repeat[$x], '1') !== false){
                    $post_data['monday'] = 1;
                }
                else if(strpos($repeat[$x], '2') !== false){
                    $post_data['tuesday'] = 1;
                }
                else if(strpos($repeat[$x], '3') !== false){
                    $post_data['wednesday'] = 1;
                }
                else if(strpos($repeat[$x], '4') !== false){
                    $post_data['thursday'] = 1;
                }
                else if(strpos($repeat[$x], '5') !== false){
                    $post_data['friday'] = 1;
                }
                else if(strpos($repeat[$x], '6') !== false){
                    $post_data['saturday'] = 1;
                }
            }
            
            
//            location_id
            $cond['id'] = getVal('id', 'class_schedule', 'class_id', $_POST['class_id']);
            $update = $this->api_model->update('class_schedule', $post_data, $cond);
            
            }
            
            
            
            $approved_students = $this->api_model->getClassApprovedStudents($_POST['class_id']);
            for ($x= 0; $x < count($approved_students); $x++){
             $temp = $approved_students[$x];
             $regIds = $this->api_model->getFirebaseRegistrationIds($temp['student_id']);
             $message = array();
             $message['class_id'] = $_POST['class_id'];
             $message['user_id'] = $_POST['user_id'];
             $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
             $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
             $message['class_name'] = getVal('name', 'class', 'id', $_POST['class_id']);
             $desc = $message['user_name']." has updated your ".$message['class_name']." class.";
             $this->send_notification($regIds, $message,"Class updated.",$desc, $temp['student_id'],1);
                       
            
             $not_logs['user_id'] = $temp['student_id'];
             $not_logs['sender_id'] = $_POST['user_id'];
             $not_logs['class_id'] = $_POST['class_id'];
             $not_logs['action'] = 'class';
             $not_logs['description'] = $desc;
             $insert = $this->api_model->create('notifications_logs', $not_logs);
             
            }
            
            
             
            
            
            $this->makeLog($_POST['user_id'], "Update Class",NULL ,NULL, "User has updated class");
            $data['status'] = 1;
            $data['class'] = $this->api_model->getClassDetail($_POST['user_id'],$_POST['class_id']);
            
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    
    
     function updatePrivateClass(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        $this->exitIfInactive($_POST['user_id']);
        
        if($_POST['user_id'] <> '' && $_POST['class_id'] <> ''){
            $post_data = array();
            if($_POST['category_id']){
                $post_data['category_id'] = $_POST['category_id'];
            }
            if($_POST['class_name']){
                $post_data['name'] = $_POST['class_name'];
            }
            
            if($_POST['last_joining_date']){
                $post_data['last_joining_date'] = $_POST['last_joining_date'];
            }
            if($_POST['start_date']){
                $post_data['start_date'] = $_POST['start_date'];
            }
            if($_POST['end_date']){
                $post_data['end_date'] = $_POST['end_date'];
            }
            if($_POST['address']){
                $post_data['address'] = $_POST['address'];
            }
            
            $cond = array();
            $cond['id'] = $_POST['class_id'];
            $cond['guru_id'] = $_POST['user_id'];
             
            $update = $this->api_model->update('private_class', $post_data, $cond);
            
            unset($post_data);
            $post_data = array();
            unset($cond);
            $cond = array();
           
            
            if($_POST['start_time']){
                $post_data['start_time'] = $_POST['start_time'];
            }
            if($_POST['end_time']){
                $post_data['end_time'] = $_POST['end_time'];
            }
            $repeat_array = array();
            
            if($_POST['repeat']){
                $post_data['sunday'] = 0;
                $post_data['monday'] = 0;
                $post_data['tuesday'] = 0;
                $post_data['wednesday'] = 0;
                $post_data['thursday'] = 0;
                $post_data['friday'] = 0;
                $post_data['saturday'] = 0;
                
                $repeat = $_POST['repeat'];
                $repeat = explode(",", $repeat);
                for($x=0; $x < count($repeat); $x++){
                if(strpos($repeat[$x], '0') !== false){
                    $post_data['sunday'] = 1;
                }
                else if(strpos($repeat[$x], '1') !== false){
                    $post_data['monday'] = 1;
                }
                else if(strpos($repeat[$x], '2') !== false){
                    $post_data['tuesday'] = 1;
                }
                else if(strpos($repeat[$x], '3') !== false){
                    $post_data['wednesday'] = 1;
                }
                else if(strpos($repeat[$x], '4') !== false){
                    $post_data['thursday'] = 1;
                }
                else if(strpos($repeat[$x], '5') !== false){
                    $post_data['friday'] = 1;
                }
                else if(strpos($repeat[$x], '6') !== false){
                    $post_data['saturday'] = 1;
                }
            }
            
            
            
//            location_id
            $cond['id'] = getVal('id', 'private_class_schedule', 'class_id', $_POST['class_id']);
            $update = $this->api_model->update('private_class_schedule', $post_data, $cond);
            
            }
            
              
            $to_id = 0; 
            $message = array();
            $private_guru_id = getVal('guru_id', 'private_class', 'id', $_POST['class_id']);
            $private_student_id = getVal('user_id', 'private_class', 'id', $_POST['class_id']);
            $desc = "";
            if ($private_guru_id == $_POST['user_id']){
                $to_id = $private_student_id;
                $message['class_id'] = $_POST['class_id'];
                $message['guru_id'] = $_POST['user_id'];
                $message['guru_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                $message['guru_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                $message['class_name'] = getVal('name', 'private_class', 'id', $_POST['class_id']);
                $desc = $message['guru_name']." has updated your private ".$message['class_name']." class.";
            
            }
            else if ($private_student_id == $_POST['user_id']){
                $to_id = $private_guru_id;
                $message['class_id'] = $_POST['class_id'];
                $message['user_id'] = $_POST['user_id'];
                $message['user_avatar'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                $message['user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                $message['class_name'] = getVal('name', 'private_class', 'id', $_POST['class_id']);
                $desc = $message['user_name']." has updated your private ".$message['class_name']." class.";
            }
            $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
            
            $this->send_notification($regIds, $message,"Private class updated.",$desc,$to_id,1);
            
            $not_logs['user_id'] = $to_id;
            $not_logs['sender_id'] = $_POST['user_id'];
            $not_logs['class_id'] = $_POST['class_id'];
            $not_logs['action'] = 'privateClass';
            $not_logs['description'] = $desc;
            $insert = $this->api_model->create('notifications_logs', $not_logs);
                     
            
            
            $this->makeLog($_POST['user_id'], "Update Private Class",NULL ,NULL, "User has updated private class");
            $data['status'] = 1;
            $data['class'] = $this->api_model->getPrivateClassDetail($_POST['user_id'],$_POST['class_id']);
            
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    
    function search(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['city_id'] <> '' && $_POST['country_id'] <> '' && $_POST['category_id'] <> '' && $_POST['filter_id'] <> '' && $_POST['query'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['gurus'] = $this->api_model->searchGurus($_POST['user_id'],$_POST['city_id'],$_POST['country_id'],$_POST['category_id'],$_POST['filter_id'],$_POST['query'],0,10);
            $data['classes'] = $this->api_model->searchClasses($_POST['user_id'],$_POST['city_id'],$_POST['country_id'],$_POST['category_id'],$_POST['filter_id'],$_POST['query'],0,10);
        
            $this->makeLog($_POST['user_id'], "Search", NULL,NULL, "User Searched: ".$_POST['query']);
           
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
        
        
    }
    
    function searchGuru(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['city_id'] <> '' && $_POST['country_id'] <> '' && $_POST['category_id'] <> '' && $_POST['filter_id'] <> '' && $_POST['query'] <> '' && $_POST['index'] <> ''&& $_POST['count'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['gurus'] = $this->api_model->searchGurus($_POST['user_id'],$_POST['city_id'],$_POST['country_id'],$_POST['category_id'],$_POST['filter_id'],$_POST['query'],$_POST['index'],$_POST['count']);
            $this->makeLog($_POST['user_id'], "Search GURU", NULL,NULL, "User Searched: ".$_POST['query']);
         
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
        
        
    }
    
    function searchClasses(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['city_id'] <> '' && $_POST['country_id'] <> '' && $_POST['category_id'] <> '' && $_POST['filter_id'] <> '' && $_POST['query'] <> '' && $_POST['index'] <> ''&& $_POST['count'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['classes'] = $this->api_model->searchClasses($_POST['user_id'],$_POST['city_id'],$_POST['country_id'],$_POST['category_id'],$_POST['filter_id'],$_POST['query'],$_POST['index'],$_POST['count']);
            $this->makeLog($_POST['user_id'], "Search Class", NULL,NULL, "User Searched: ".$_POST['query']);
            
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
        
        
    }
    
    
    function getSearchCategories(){
        $data = array();
        
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' ) {
            
            $this->exitIfInactive($_POST['user_id']);       
            $data['status'] = 1;
            $data['categories'] = $this->api_model->getSearchCategories();
        }
        
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function getSearchFilters(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' ) {
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['filters'] = $this->api_model->getSearchFilters();
        }
        
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    
    function fetchMessageThreads(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if($_POST['user_id'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
           
            $data['status'] = 1;
            $data['threads'] = $this->api_model->fetchMessageThreads($_POST['user_id'],$_POST['index'],$_POST['count']);
            $data['message_badge'] = getVal('message_badge', 'user', 'user_id', $_POST['user_id']);
            
            for ($x = 0; $x < count($data['messages'] ); $x++){
                $data['threads'][$x]["message"] = '|||'. $data['threads'][$x]["message"]; 
            }

        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
         
        header('Content-Type: application/json');
        echo str_replace("|||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }
    
    
    function fetchMessages(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        
        if(($_POST['user_id'] <> '' && $_POST['thread_id'] <> ''  && $_POST['count'] <> '' )){
            
            $this->exitIfInactive($_POST['user_id']);
            $data['status'] = 1;
            $data['messages'] = array_values($this->api_model->fetchMessages($_POST['user_id'],$_POST['thread_id'],$_POST['count'],$_POST['before'],$_POST['after']));
            
            for ($x = 0; $x < count($data['messages'] ); $x++){
                $data['messages'][$x]["message"] = '|||'. $data['messages'][$x]["message"]; 
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        
        header('Content-Type: application/json');
        echo str_replace("|||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }
    
    function sendMessage(){
        $data = array();
        $post_data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' &&  ($_POST['thread_id'] <> ''  || $_POST['to_id'] <> '') && $_POST['message'] <> ''){
           
           $this->exitIfInactive($_POST['user_id']);
            
            if($_POST['thread_id'] <> ''){
                $from_id = getVal('from_id', 'thread', 'id', $_POST['thread_id']);
                $to_id = getVal('to_id', 'thread', 'id', $_POST['thread_id']);
                
                $this->exitIfInactive($from_id);
                $this->exitIfInactive($to_id);
                
                $post_data['thread_id'] = $_POST['thread_id'];
                $post_data['message'] = $_POST['message'];
                $post_data['from_user_id'] = $_POST['user_id'];
                
                if($from_id == $_POST['user_id']){
                   $post_data['to_user_id'] = $to_id;
                }
                else if($to_id == $_POST['user_id']){
                    $post_data['to_user_id'] = $from_id;
                }
                
                $message_id = $this->api_model->create('messages', $post_data);
                if($message_id>0){
                    $to_id = $post_data['to_user_id'] ;
                    $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                    $message = array();
                    $message['sender_user_id'] = $_POST['user_id'];
                    $message['thread_id'] = $_POST['thread_id'];
                    $message['sender_user_pic'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                    $message['sender_user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                    
                    $flag = $this->api_model->shouldIncrementMessageBadge($to_id,$_POST['thread_id'],$message_id);
                    if ($flag == 0) {
                        $this->send_notification($regIds, $message,"New message received",$message['sender_user_name']." has sent you a message.",$to_id,3);
                    }
                    else if ($flag == 1) {
                        $this->send_notification($regIds, $message,"New message received",$message['sender_user_name']." has sent you a message.",$to_id,2);
                    }
                    
                   
                    
                    $data['status'] = 1;
                    $data['message_id'] = $message_id;
                    $data['thread_id'] = $_POST['thread_id'];
                    
                    $post_data =array();
                    $post_data['last_update'] = date("Y-m-d h:i:sa");
                    $this->api_model->update('thread', $post_data, array('id' => $_POST['thread_id']));
                
                    
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Failed to send message.';
                }
                
            }
            else if($_POST['to_id'] <> '' && $_POST['to_id'] <> 0){
                $this->exitIfInactive($_POST['user_id']);
                $this->exitIfInactive($_POST['to_id']);
                $thread_check = $this->api_model->verifyThreadExist($_POST['user_id'],$_POST['to_id']);
                if($thread_check == 0){
                    $post['from_id'] = $_POST['user_id'];
                    $post['to_id'] = $_POST['to_id'];
                    $post_data['last_update'] = date("Y-m-d h:i:sa");
                    $thread_id = $this->api_model->create('thread', $post);
                    $thread_check = $thread_id;
                }
                
                if($thread_check > 0){
                        $data['thread_id'] = $thread_check;
                        $post_data = array();
                        $post_data['thread_id'] = $thread_check;
                        $post_data['message'] = $_POST['message'];
                        $post_data['from_user_id'] = $_POST['user_id'];
                        $post_data['to_user_id'] = $_POST['to_id'];
                        $message_id = $this->api_model->create('messages', $post_data);
                        if($message_id>0){
                            
                            $to_id = $post_data['to_user_id'] ;
                            $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
                            $message = array();
                            $message['sender_user_id'] = $_POST['user_id'];
                            $message['thread_id'] = $thread_check;
                            $message['sender_user_pic'] = getVal('avatar', 'user', 'user_id', $_POST['user_id']);
                            $message['sender_user_name'] = getVal('name', 'user', 'user_id', $_POST['user_id']);
                            
                            $flag = $this->api_model->shouldIncrementMessageBadge($to_id,$thread_check,$message_id);
                            if ($flag == 0) {
                                $this->send_notification($regIds, $message,"New message received",$message['sender_user_name']." has sent you a message.",$to_id,3);
                            }
                            else if ($flag == 1) {
                                $this->send_notification($regIds, $message,"New message received",$message['sender_user_name']." has sent you a message.",$to_id,2);
                            }
                            
                            $data['status'] = 1;
                            $data['message_id'] = $message_id;
                            
                            $post_data =array();
                            $post_data['last_update'] = date("Y-m-d h:i:sa");
                            $this->api_model->update('thread', $post_data, array('id' => $thread_check));
                        }
                        else{
                            $data['status'] = 0;
                            $data['message'] = 'Failed to send message.';
                        }
                    }
                    else{
                        $data['status'] = 0;
                        $data['message'] = 'Failed to send message.';
                    }
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    function markAsRead(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' &&  $_POST['message_ids'] <> ''){
           
           
           $this->exitIfInactive($_POST['user_id']);
           $messageIdArrays = array();
           
            $markids = $markids = array_filter(explode(',', $_POST['message_ids']));
                    if (!empty($markids) && is_array($markids)) {
                        foreach ($markids as $_id) {
                            if (strpos($_id, '[') !== false) {
                                $string = mb_strimwidth($_id,1, strlen($_id));
                                $post_data =array();
                                $post_data['is_read'] = 1;
                                $messageIdArrays[count($messageIdArrays)] = $string;
                                $this->api_model->update('messages', $post_data, array('message_id' => $string));
                
                            }
                            else if (strpos($_id, ']') !== false) {
                                $string = mb_strimwidth($_id,0, strlen($_id)-1);
                                $post_data =array();
                                $post_data['is_read'] = 1;
                                $messageIdArrays[count($messageIdArrays)] = $string;
                                $this->api_model->update('messages', $post_data, array('message_id' => $string));
                            }
                            else{
                                $post_data =array();
                                $post_data['is_read'] = 1;
                                $messageIdArrays[count($messageIdArrays)] = $_id;
                                $this->api_model->update('messages', $post_data, array('message_id' => $_id));
                            }
                        }
                        $this->api_model->updateMessageBadgeIfRequired($_POST['user_id'],$messageIdArrays);
                        $data['status'] = 1;
                    }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function markAllRead(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' &&  $_POST['thread_id'] <> ''){
           
           
           $this->exitIfInactive($_POST['user_id']);
            
            $result = $this->api_model->getMessageIdsToUser($_POST['user_id'],$_POST['thread_id']);
            for ($x = 0; $x < count($result); $x++){
                $post_data =array();
                $post_data['is_read'] = 1;
                $this->api_model->update('messages', $post_data, array('message_id' => $result[$x]['message_id']));
            }
            $this->api_model->getMessageBadgeDecremented($_POST['user_id']);
            $data['status'] = 1;
            $data['message'] = 'Messages marked read successfully.';
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function markAllReadCustom($user_id,$thread_id){
            if ($this->api_model->verifyShouldDecrementBadge($user_id,$thread_id)) {
                $this->api_model->getMessageBadgeDecremented($user_id);
            }
    }
    
    
    function deleteMessages(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' &&  $_POST['message_ids'] <> ''){
           
           $this->exitIfInactive($_POST['user_id']);
            
            $delids = $delids = array_filter(explode(',', $_POST['message_ids']));
            $badgeFlag = true;
                    if (!empty($delids) && is_array($delids)) {
                        foreach ($delids as $_id) {
                            if (strpos($_id, '[') !== false) {
                                $string = mb_strimwidth($_id,1, strlen($_id));
                                $from_id = getVal('from_user_id', 'messages', 'message_id', $string);
                                $post_data =array();
                                if($from_id == $_POST['user_id']){
                                    $post_data['sender_status'] = 0;
                                }
                                else{
                                     $post_data['receiver_status'] = 0;
                                }
                                $this->api_model->update('messages', $post_data, array('message_id' => $string));
                
                            }
                            else if (strpos($_id, ']') !== false) {
                                $string = mb_strimwidth($_id,0, strlen($_id)-1);
                                $from_id = getVal('from_user_id', 'messages', 'message_id', $string);
                                $post_data =array();
                                if($from_id == $_POST['user_id']){
                                    $post_data['sender_status'] = 0;
                                }
                                else{
                                     $post_data['receiver_status'] = 0;
                                     
                                }
                                $this->api_model->update('messages', $post_data, array('message_id' => $string));
                            }
                            else{
                                $from_id = getVal('from_user_id', 'messages', 'message_id', $_id);
                                $post_data =array();
                                if($from_id == $_POST['user_id']){
                                    $post_data['sender_status'] = 0;
                                }
                                else{
                                    if ($badgeFlag == true) {
                                        $decFlag = getVal('is_read', 'messages', 'message_id', $_id);
                                        if ($decFlag == 0){
                                            $badgeFlag = false;
                                            $this->api_model->getMessageBadgeDecremented($_POST['user_id']);
                                        }
                                    }
                                     $post_data['receiver_status'] = 0;
                                }
                                $this->api_model->update('messages', $post_data, array('message_id' => $_id));
                            }
                        }
                         $data['status'] = 1;
                    }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    } 
    
    
    
    
    
    
    function deleteThread(){
       $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' &&  $_POST['thread_id'] <> ''){
            
            $this->exitIfInactive($_POST['user_id']);
            $this->markAllReadCustom($_POST['user_id'], $_POST['thread_id']);
            $thread_id = $_POST['thread_id'];
            $updated = 0;
            $message_ids = $this->api_model->getMessageIds($thread_id);
            for($x=0;$x<count($message_ids);$x++){
                $id = $message_ids[$x]['message_id'];
                $from_id = getVal('from_user_id', 'messages', 'message_id', $id);
                $post_data =array();
                if($from_id == $_POST['user_id']){
                    $post_data['sender_status'] = 0;
                 }
                 else{
                    $post_data['receiver_status'] = 0;
                 }
                $updated = $this->api_model->update('messages', $post_data, array('message_id' => $id));
            }
            
            if ($updated > 0){
                $data['status'] = 1;
                $data['message'] = 'Thread deleted';
            }
            else{
                $data['status'] = 0;
                $data['message'] = 'Failed to delete thread';
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }


    /**
     * Method: updateProfile
     * params: Posted Data $post
     * Return: Json
     */
    function updateProfile() {
        $data = array();

        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);

        $post_data = array();
        if ($_POST['user_id'] <> '') {
            
            $this->exitIfInactive($_POST['user_id']);
        
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            
            if ($verify == 1) {

       
                  $verifyEmail = $verifyPhone = 1;

                    if ($verifyEmail == 1 || $verifyPhone == 1) {
                        

                        $user_id = $_POST['user_id'];
                        $post_data=$this->api_model->get_user_data($user_id);
                        
                        if($_POST['name'])
                            $post_data['name'] = $_POST['name'];
                        if($_POST['username'])
                            $post_data['username'] = $_POST['username'];
                        
                        if($_POST['fb_url'])
                            $post_data['fb_url'] = $_POST['fb_url'];
                        if($_POST['tw_url'])
                            $post_data['tw_url'] = $_POST['tw_url'];
                        
                        if($_POST['soundcloud_url'])
                            $post_data['soundcloud_url'] = $_POST['soundcloud_url'];
                        
                        if($_POST['web_url'])
                            $post_data['web_url'] = $_POST['web_url'];
                        
                            $post_data['updated_at'] = date('Y-m-d H:i:s');
                        $results = $this->api_model->update('users', $post_data, array('user_id' => $user_id));
                        if ($results > 0) {
//                               
                            $data = $this->api_model->get_user_data($user_id);
                            $data['user_id']        = '||'.$data['user_id'];
                            $data['name']           = '||'.$data['name'];
                            $data['email']          = '||'.$data['email'];
                            $data['phone_no']       = '||'.$data['phone_no'];
                            $data['avatar']         = '||'.$data['avatar'];
                            $data['fb_url']         = '||'.$data['fb_url'];
                            $data['tw_url']         = '||'.$data['tw_url'];
                            $data['soundcloud_url'] = '||'.$data['soundcloud_url'];
                            $data['web_url']        = '||'.$data['web_url'];
                            $data['cover_photo']    = '||'.$data['cover_photo'];
                            $data['is_verified']    = '||'.$data['is_verified'];
                            $data['status'] = 1; 
                            $this->makeLog($_POST['user_id'], "Update profile", NULL,NULL, "User has updated profile.");
         
                        } else {
                            $data['status'] = 0;
                            $data['message'] = 'Profile not updated. Please try again later.';
                        }
                    } else {
                        //$r = $verifyPhone == 0?'Phone No':'Email';
                        $data['status'] = 0;
                        $data['error'] = 202;
                        $data['message'] = $r.' already exists. Please try another one.';
                    }
                
               

            } 
            
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['error'] = 203;
                $data['message'] = 'User not exist.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 204;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo str_replace("||","",json_encode($data, JSON_NUMERIC_CHECK));
        exit;
    }

    
    
    
    /**
     * Method: updatePhoto
     * params: Posted Data $post
     * Return: Json
     */
    function updatePhoto() {
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        $post_data = array();
        if ($_POST['user_id'] <> '') {
            $this->exitIfInactive($_POST['user_id']);
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if ($verify == 1) {
                $user_id = $_POST['user_id'];
                $old_photo = end(explode('/', getVal('avatar', 'users', 'user_id', $user_id)));
                $old_photo_cover = end(explode('/', getVal('cover_photo', 'users', 'user_id', $user_id)));
                if ($_FILES['avatar']['name'] != '') {
                    unlink('uploads/users/pic/' . $old_photo);
                    unlink('uploads/users/small/' . $old_photo);
                    unlink('uploads/users/medium/' . $old_photo);
                    $extension = $this->common->getExtension($_FILES ['avatar'] ['name']);
                    $extension = strtolower($extension);
                    if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                        return false;
                    }
                    $path = 'uploads/users/';
                    $allow_types = 'gif|jpg|jpeg|png';
                    $max_height = '8000';
                    $max_width = '8000';
                    $avatar = $this->common->do_upload_profile($path, $allow_types, $max_height, $max_width, $_FILES ['avatar']['tmp_name'], $_FILES ['avatar']['name']);
                    $post_data['avatar'] = $photo = base_url('uploads/users/medium/' . $avatar);
                }
                if ($_FILES['cover_photo']['name'] != '') {
                    unlink('uploads/users/pic/' . $old_photo_cover);
                    unlink('uploads/users/small/' . $old_photo_cover);
                    unlink('uploads/users/medium/' . $old_photo_cover);
                    $extension = $this->common->getExtension($_FILES ['cover_photo'] ['name']);
                    $extension = strtolower($extension);
                    if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                        return false;
                    }
                    $path = 'uploads/users/';
                    $allow_types = 'gif|jpg|jpeg|png';
                    $max_height = '8000';
                    $max_width = '8000';
                    $cover_photo = $this->common->do_upload_profile($path, $allow_types, $max_height, $max_width, $_FILES ['cover_photo']['tmp_name'], $_FILES ['cover_photo']['name']);
                    $post_data['cover_photo'] = $photo_cover = base_url('uploads/users/medium/' . $cover_photo);
                }
                
                $results = $this->api_model->update('users', $post_data, array('user_id' => $user_id));

                if ($results) {
                    $data['status'] = 1;
                    if ($avatar <> '') {
                        $data['avatar'] = $photo;
                        $this->makeLog($_POST['user_id'], "Update photo", NULL,NULL, "User has updated photo.");
                    }
                    if ($cover_photo <> '') {
                        $data['cover_photo'] = $cover_photo;
                        $this->makeLog($_POST['user_id'], "Update photo", NULL,NULL, "User has updated photo.");
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = 'Profile not updated. Please try again later.';
                }
            }
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    /**
     * Method: getUserProfile
     * params: Posted Data $post
     * Return: Json
     */
    function getUserProfile() {
        $data = array();
        $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        if ($_GET['user_id'] <> '' || $_GET['user_id'] <> 0) {
            $this->exitIfInactive($_GET['user_id']);
            $user_id = $_GET['user_id'];
            $verify = $this->api_model->verify_user_id($user_id);
            if ($verify == 1) {
                $data['status'] = 1;
                $data['user'] = $this->api_model->get_user_data($user_id);
            } else {
                $data['status'] = 0;
                $data['message'] = 'User not exist.';
            }
        } else {
            $data['status'] = 0;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    /**
     * Method: forgotPassword
     * params: Posted Data
     * Retruns: Json
     */
    function forgotPassword() {
        $data = array();
        
               
        if ($_POST['email'] <> '' ) {
            
            $email = $_POST['email'];
            if ($email <> '') {
                
                $res = $this->api_model->verify_email($email);
                 
                if ($res == 0) {
                   
                    $email = $_POST['email'];   
                    $user_id = getVal('user_id', 'users', 'email', $email);
                                        

                        $e_data['receiver_name'] = "Tag a Long User";
                        $e_data['email_content'] = "It looks like you requested to reset password. 
                                <br />
                                Click on the below link to set your new password.
                                <br /><br />
                                Reset Password Link: <b>". base_url()."home/forgotPassword/" .$this->common->encode($user_id) . "</b>
                                <br /><br />
                                if you did not request to reset password, please ignore this email. If you feel something is wrong, please contact our support team: admin@tagalong.com.
                                ";

                            $e_data['title'] = 'Reset Password';
                            $e_data['content'] = $data['email_content'];
                            $e_data['welcome_content'] = "Greetings ".$data['receiver_name'];
                            $e_data['footer'] = "Regards";
                            $subject = $e_data['title'];
                            
                            
                            $email_content = $this->load->view('includes/email_templates/email_template', $e_data, true);
                           
                            $this->emailutility->send_email_user($email_content, $email, $subject);
                          
                        
                            unset($e_data);
                    
                        $this->makeLog($user_id,"Forgot password", NULL,NULL, "User has forgot password.");
         
                        $data['status'] = 1;
                        $data['message'] = 'Please Check your email for password recovery.';
                      
//                    }
                } 
                
                else if ($res == -1){
                     $data['status'] = 0;
                     $data['error'] = 204;
                     $data['message'] = 'The user you are trying to access is inactive.';
                }
                else {
                    $data['status'] = 0;
                    $data['error'] = 202;
                    $data['message'] = 'Email "' . $_POST['email'] . '" not exists. Please try another email.';
                }
            } else{
                $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    
    /**
     * Method: deleteAccount
     * params: Posted Data $post
     * Return: Json
     */
     
    function deleteAccount(){
        $data = array();
        if ($_POST['user_id'] <> '' ) {
            
            $this->exitIfInactive($_POST['user_id']);
        
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if ($verify == 1) {
               
                $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
                $post_data = array();
                $post_data['user_id'] = $_POST['user_id'];
                $result = $this->api_model->delete('users', $post_data);
                if($result){
                    $this->makeLog($_POST['user_id'],"Delete Account", NULL,NULL, "User has deleted his account.");
                    $data['status'] = 1;
                    $data['message'] = "successfully deleted user account ";
                }
                else{
                    $this->makeLog($_POST['user_id'],"Delete Account Denied", NULL,NULL, "Failed to delete user account.");
                    $data['status'] = 0;
                    $data['message'] = 'Failed to delete user account, Please try again.';
                }    
            }
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    
    /**
     * Method: deactiviateAccount
     * params: Posted Data $post
     * Return: Json
     */
     
    function deactiviateAccount(){
        $data = array();
        if ($_POST['user_id'] <> '' ) {
            $_POST['user_id'];
            
            $this->exitIfInactive($_POST['user_id']);
        
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if ($verify == 1) {
                $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
                    $post_data = array();
                    $cond = array();
                    $post_data['is_active'] = 0;
		    //$post_data['active'] = 0;
                    $cond['user_id'] = $_POST['user_id'];
                    $result = $this->api_model->update('users',$post_data,$cond);
                    
                if($result){
                    
                    //$del_data = array();
                    //$del_data['user_id'] = $_POST['user_id'];
                    //$result = $this->api_model->delete('user_firebase_tokens', $del_data);
                    //$this->notifyAllStudents($_POST['user_id']);
                    $this->makeLog($_POST['user_id'],"Deactivate Account", NULL,NULL, "User has deactivated his account.");
                    $data['status'] = 1;
                    $data['message'] = "successfully deactivated user account ";
                }
                else{
                    $this->makeLog($_POST['user_id'],"Deactivate Account Denied", NULL,NULL, "Failed to deactivat user account.");
                    $data['status'] = 0;
                    $data['message'] = 'Failed to deactivat user account, Please try again.';
                }    
            }
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    
    
    public function notifyAllStudents($id) {
        
        $guruName = getVal('name', 'user', 'user_id', $id);
        $results = $this->api_model->getAllApprovedStuddents($id); 
        foreach($results as $res)
        {
            $message = array();
            $to_id = $res['user_id'] ;
            $regIds = $this->api_model->getFirebaseRegistrationIds($to_id);
            $this->send_notification($regIds, $message,"Guru Deactivated...! ",$guruName." has been deactivated.",$to_id,1);
            
            $not_logs['user_id'] = $to_id;
            $not_logs['sender_id'] = $id;
//            $not_logs['class_id'] = $class_id;
//            $not_logs['action'] = 'privateClass';
            $not_logs['description'] = $guruName." has been deactivated.";
            $insert = $this->api_model->create('notifications_logs', $not_logs);
              
        }
    }
    
    
    /**
     * Method: getCountries
     * params: Posted Data $post
     * Return: Json
     */
     
    function getCountries(){
        $data = array();
        
        $results = $this->api_model->getCountries();
        if($results){
            $data['status'] = 1;
            $data['countries'] = $results; 
        } else{
            $data['status'] = 1;
            $data['countries'] = array();
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    
    /**
     * Method: getCities
     * params: Posted Data $post
     * Return: Json
     */
     
    function getCities(){
        $data = array();
        
        $results = $this->api_model->getCities($_GET['country_id']);
        if($results){
            $data['status'] = 1;
            $data['cities'] = $results; 
        } else{
            $data['status'] = 1;
            $data['cities'] = array();
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    
    
    
    
     
    /**
     * Method: submitFeedback
     * params: Posted Data $post
     * Return: Json
     */
     
    function submitFeedback(){
        $data = array();
        if ($_POST['user_id'] <> '' && $_POST['feedback_message'] <> '' ) {
            $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
            
            $this->exitIfInactive($_POST['user_id']);
        
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if ($verify == 1) {
                $feedback = array();
                $feedback['user_id'] = $_POST['user_id'];
                $feedback['feedback_message'] = $_POST['feedback_message'];
                $feedback_id = $this->api_model->create('users_feedback', $feedback);
                if($feedback_id>0){
                    $this->makeLog($_POST['user_id'],"Submit Feedback", NULL,NULL, "User has submitted feedback.");
                    $data['status'] = 1;
                    $data['message'] = 'Feedback received successfully.';
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Feedback failed. Please try again later.';
                }
            } else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    
    
    


   
    
    
    /**
     * Method: getAllNotifications
     * params: Posted Data
     * Return: Json
     */

    function getAllNotifications(){
        $data = array();
        $offset = $_GET['offset'];
        $limit = $_GET['limit'];
        $user_id = $_GET['user_id'];
        $this->common->matchSecretKey($_GET['user_id'], $this->secret_key);
        
        if ($_GET['user_id'] <> '' ) {
            $this->resetBadgeNumber($_GET['user_id']);
            $this->exitIfInactive($_GET['user_id']);
            $results = $this->api_model->getAllNotifications( $offset, $limit, $user_id);
            if ($results <> null ) {
                   $data['status'] = 1;
                   $data['notifications'] = $results;
            } else {
                $data['status'] = 0;
                   $data['message'] = 'No notifications found';
            }
        }
        else{
             $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
            
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    
   
    /**
     * Method: updateNotificationToken
     * params: Posted Data
     * Retruns: Json
     */
    function updateNotificationToken() {
        
        $data = array();
        $post_data = array();
        if ($_POST['user_id'] <> '' && $_POST['user_token'] <> '' && $_POST['device_id'] <> '') {
            
            if ($_POST['user_id'] == 0 || $_POST['user_id'] == '0'){
                $cond = array();
                $cond['device_id'] = $_POST['device_id'];
                $result = $this->api_model->delete('user_firebase_tokens', $cond);
                $data['status'] = 1;
                $data['message'] = 'Firebase Notification Id removed';
                header('Content-Type: application/json');
                echo json_encode($data, JSON_NUMERIC_CHECK);
                exit;
            }
            
             $cond = array();
             $cond['device_id'] = $_POST['device_id'];
             $result = $this->api_model->delete('user_firebase_tokens', $cond);
               
            
            $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if($verify == 1){
//                $isExist = $this->api_model->ifExistUserDevice($_POST['device_id']);
//                $result = 0;
//                if ($isExist == FALSE){
                    $post_data['user_id'] = $_POST['user_id'];
                    $post_data['firebase_token'] = $_POST['user_token'];
                    $post_data['device_id'] = $_POST['device_id'];
                    $result = $this->api_model->create('user_firebase_tokens', $post_data);
            
//                }
//                else{
//                    $post_data = array();
//                    $cond = array();
//                    $post_data['firebase_token'] = $_POST['user_token'];
//                    $post_data['user_id'] = $_POST['user_id'];
//                    $cond['device_id'] = $_POST['device_id'];
//                    $result = $this->api_model->update('user_firebase_tokens',$post_data,$cond);
//                }
                
                if($result>0){
                    $data['status'] = 1;
                    $data['message'] = 'Firebase Notification Id successfully updated';
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Failed to update firebase notification id';
                }
                
            } 
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        }
        else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    

    
    /**
     * Method: logout
     * params: Posted Data
     * Retruns: Json
     */
    function logout() {
        
        $data = array();
        $post_data = array();
        if ($_POST['user_id'] <> '' && $_POST['device_id'] <> '') {
            $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
            $this->resetBadgeNumber($_POST['user_id']);
            //$this->exitIfInactive($_GET['user_id']);
            
            $verify = $this->api_model->verify_user_id($_POST['user_id']);
            if($verify == 1){
                $post_data['user_id'] = $_POST['user_id'];
                $post_data['device_id'] = $_POST['device_id'];
                $result = $this->api_model->delete('user_firebase_tokens', $post_data);
                if($result){
                    $this->makeLog($_POST['user_id'],"Log out", NULL,NULL, "User has logged out.");
                    $data['status'] = 1;
                    $data['message'] = "Successfully logged out ";
                }
                else{
                    $data['status'] = 0;
                    $data['message'] = 'Failed to logout.';
                }    
                
            }
            else if ($verify == -1){
                $data['status'] = 0;
                $data['error'] = 204;
                $data['message'] = 'The user you are trying to access is inactive.';
            }
            else {
                $data['status'] = 0;
                $data['message'] = 'User not Exists.';
            }
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }

    public function payment() {
        $data = array();
        $input = file_get_contents('php://input');
        $order = (array)json_decode($input);
        $user_id = $order['user_id'];
        $nonce = $order['nonce'];
        $message = $order['message'];
        $recepient_name = $order['recepient_name'];
        $is_surprise = $order['is_surprise'];
        $uk_store = $order['uk_store'];
        $usa_store = $order['usa_store'];
        $vendors = ($order['vendors']);
//        echo 'Hello';
//        print_r($order['vendors']);
//        print_r($vendors);
//        echo count($vendors);
//        
//        echo $vendors[0]->key;
//        echo $vendors[0]['val'];
//          
        $this->common->matchSecretKey($user_id, $this->secret_key);
        if ($user_id <> '' || $user_id <> 0) {
            $verify = $this->api_model->verify_user_id($user_id);
            if ($verify == 1) {
               
                if(($uk_store == null || $uk_store == '' || $uk_store == '0') &&
                  ($usa_store == null || $usa_store == '' || $usa_store == '0')){
                    $data['status'] = 0;
                    $data['message'] = 'Please select a uk/usa store.';
        
                    header('Content-Type: application/json');
                    echo json_encode($data, JSON_NUMERIC_CHECK);
                    exit;
                }
                $subtotal_products = 
                        $this->api_model->getSubTotalAndProducts($user_id,/*$amt,*/$uk_store,$usa_store);
                $delivery_charges = 0;
                for($x = 0 ; $x<count($vendors); $x++){
                    $delivery_charges += 
                            $this->api_model->getVendorDeliveryCharge($vendors[$x]->delivery_id,$vendors[$x]->vendor_id);
                }
                $grand_total = $subtotal_products['sub_total']+$delivery_charges;
                
                 
                 $this->load->library("braintree_lib");

                 $result = $this->braintree_lib->sale([
                    'amount' => $grand_total,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                        'submitForSettlement' => True
                    ]
                 ]);

                 if ($result->success == 1) {
                    
                  $transactions = $result->transaction;
                  $postData = array();
                  $postData['user_id'] = $user_id;
                  $postData['transaction_key'] = $transactions->id;
                  $postData['url'] = $this->getOrderUrl();
                  $postData['message'] = $message;
                  $postData['is_surprise'] = $is_surprise;
                  
                  
                  $timestamp = time();
                  $date = strtotime("+7 day", $timestamp);
                  $expire_timestamp = date('Y-m-d H:i:s', $date);
//                  $expire_timestamp = date('Y-m-d H:i:s');
                  $postData['expiration_timestamp'] = $expire_timestamp;
                  
                  $postData['accepted_status'] = 0;
                  $postData['processes_status'] = 0;
                  $postData['recepient_name'] = $recepient_name;
                  $postData['sub_total'] = $subtotal_products['sub_total'];
                  $postData['delivery_charges'] = $delivery_charges;
                  $postData['total'] = $postData['sub_total'] + $postData['delivery_charges'];
                  $postData['payment_type'] = $transactions->creditCardDetails->cardType;
                  $postData['payment_hint'] = $transactions->creditCardDetails->last4;
                  
                  $order_id = $this->api_model->create('users_orders', $postData);
                  
                  $post_data['url'] = $this->getOrderUrl(). $order_id ;
                  $newUrl = $post_data['url'];
                  $update_url = $this->api_model->update('users_orders', $post_data, array('order_id' => $order_id));
           
                  
                  
                  for($x = 0 ; $x<count($vendors); $x++){
                      $postDataVendor = array();
                      $postDataVendor['order_id'] = $order_id;
                      $postDataVendor['delivery_id'] = $vendors[$x]->delivery_id;
                      $postDataVendor['vendor_id'] = $vendors[$x]->vendor_id;
                      $this->api_model->create('orders_vendors', $postDataVendor);
                  }
                  
                   for($x = 0 ; $x<count($subtotal_products['products']); $x++){
                      $product = $subtotal_products['products'][$x];
                      $postDataProduct = array();
                      $postDataProduct['order_id'] = $order_id;
                      $postDataProduct['product_id'] = $product['product_id'];
                      $postDataProduct['price'] = $product['price'];
                      $this->api_model->create('orders_products', $postDataProduct);
                  }
                  
                  
                  $this->emptyCart($user_id,$subtotal_products['products']); 
                  $data['status'] = 1;
                  $data['url'] = $newUrl;
                   
                  } else {
                     $data['status'] = 0;
                     $data['error'] = 404;
                     $data['message'] = 'Payment not done.';
                    }
                
            } else {
                $data['status'] = 0;
                $data['message'] = 'User not exist.';
            }
        } else {
            $data['status'] = 0;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function getClientToken() {
        $data = array();

        $this->load->library("braintree_lib");

        $data['token'] = $this->braintree_lib->create_client_token();
        if ($data['token'] <> '') {
            $data['status'] = 1;
            header('Content-Type: application/json');
            echo json_encode($data, JSON_NUMERIC_CHECK);
            exit;
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
            header('Content-Type: application/json');
            echo json_encode($data, JSON_NUMERIC_CHECK);
            exit;
        }
    }
   
    function getGenre(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' || $_POST['user_id'] <> 0) {
            $this->exitIfInactive($_POST['user_id']);
            $results = $this->api_model->getGenres();
            if($results){
                $data['status'] = 1;
                $data['genres'] = $results;
            }
            else{
                $data['error'] = 402;
                $data['status'] = 0;
                $data['message'] = 'Failed to get Genres, Please try again.';
            }
        } else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
         
    }
    
    function updateMyGenre(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if($_POST['user_id'] <> '' && $_POST['genres'] <> ''){
            $this->exitIfInactive($_POST['user_id']);
            $genre_id=implode(',',json_decode($_POST['genres']));
            $post_data = array();
	    $post_data['genres'] =$genre_id;
            $cond = array();
            $cond['user_id'] = $_POST['user_id'];
            $update = $this->api_model->update('users', $post_data, $cond);
            if($update >0){
            unset($post_data);
            $post_data = array();
            unset($cond);
            $cond = array();
            $this->makeLog($_POST['user_id'], "Update Users",NULL ,NULL, "User has successfully updated genre");
            $data['message'] = 'User has successfully updated genre.';
            $data['status'] = 1;
            }
            else{
               
                $this->makeLog($_POST['user_id'], "Failed to update genre", $_POST['user_id'], "user failed to update genre");
                $data['error'] = 402;
                $data['status'] = 0;
                $data['message'] = 'User failed to update genre';
           
            }
        }
        else{
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    
    function addCreditCard(){
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' || $_POST['user_id'] <> 0) {
        $post_data['user_id']       = $_POST['user_id'];
        $post_data['first_name']    = $_POST['first_name'];
        $post_data['last_name']     = $_POST['last_name'];
        $post_data['card_number']   = $_POST['card_number'];
        $post_data['cvv']           = $_POST['cvv'];
        $post_data['expiry_month']  = $_POST['expiry_month'];
        $post_data['expiry_year']   = $_POST['expiry_year'];
        $post_data['address_line1'] = $_POST['address_line1'];
        $post_data['address_line2'] = $_POST['address_line2'];
        $post_data['city']          = $_POST['city'];
        $post_data['state']         = $_POST['state'];
        $post_data['zip']           = $_POST['zip'];
        $post_data['country']       = $_POST['country'];
        $post_data['created']       = time();
        $results = $this->api_model->create('billing_address', $post_data);
            if ($results)
            {
                $this->makeLog($results, "Credit Card information", NULL, NULL, "Credit Card information  has been saved successfully");
                $data['status'] = 1;
                $data['message'] = 'Credit Card information  has been saved successfully.';

            }
            else{
                $data['status'] = 1;
                $data['error'] = 402;
                $data['message'] = 'Failed to add Credit Card information, Please try again.';
            }
        }
        else {
                    $data['status'] = 1;
                    $data['error'] = 404;
                    $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
    function getCardInfo(){
        $data = array();
        $this->common->matchSecretKey($_POST['user_id'], $this->secret_key);
        if ($_POST['user_id'] <> '' || $_POST['user_id'] <> 0) {
            $this->exitIfInactive($_POST['user_id']);
            $user_id = $_POST['user_id'];
            $data['status'] = 1;
            $result = $this->api_model->getBillingInfo($user_id);
            foreach ($result as $k => $v) {
                $data[$k] = $v;
            }
            
        } else {
            $data['status'] = 0;
            $data['error'] = 404;
            $data['message'] = 'Invalid data provided.';
        }
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        exit;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
