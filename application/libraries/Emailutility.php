<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/*
 * @Author: Saad Khan
 *
 */

final class EmailUtility {

    function EmailUtility() {
        $this->CI = & get_Instance();
        $this->_obj = & get_instance();
        $this->CI->load->library('phpmailer');
    }

    /*
      Send Mail
      Pra @ To Email address
      Pra @ sendor name
      Pra @ sendor email address
      Pra @ subject
      Pra @ html body
      Pra @ html text
     */

    function accountVarification($email_content, $email, $subject) {
        $body_html = $email_content;

        EmailUtility::sendMail($email, SITE_NAME,ADMIN_EMAIL, $subject, $body_html);
    }

    function send_email_user($email_content, $email, $subject) {
        $body_html = $email_content;

        EmailUtility::sendMail($email, SITE_NAME, ADMIN_EMAIL, $subject, $body_html);
    }

    function send_email_admin($email_content,$subject) {
        $body_html = $email_content;

        EmailUtility::sendMail(ADMIN_EMAIL, SITE_NAME, ADMIN_EMAIL, $subject, $body_html);
    }

    function send_contact_inquiry($email_content, $subject) {
        $body_html = $email_content;

        EmailUtility::sendMail(ADMIN_EMAIL,SITE_NAME, ADMIN_EMAIL, $subject, $body_html);
    }

    function send_companyContact_inquiry($email_content, $subject,$email) {
        $body_html = $email_content;

        EmailUtility::sendMail($email,SITE_NAME, ADMIN_EMAIL, $subject, $body_html);
    }

    function leave_feedback_message($data, $email_content,$subject) {

        $body_html = $email_content;


        EmailUtility::sendMail($data['to_email'], SITE_NAME, ADMIN_EMAIL, $subject, $body_html);
    }

    function sendMail($to_email, $sendor_name, $sendor_email, $subject, $body_html, $cc = '', $bcc='') {

        $header = "";
        $header .= "From: " . $sendor_name . "<" . $sendor_email . ">\r\n";
//        $cc = 'saeed.ullah3074@hotmail.com';
        if ($cc <> '')
            $header = "cc:  " . $cc . "\r\n";
        if ($bcc <> '')
            $header = "bcc:  " . $bcc . "\r\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-type: text/html\r\n";

        mail($to_email, $subject, $body_html, $header);
       /* if( @$send = mail($to_email, $subject, $body_html, $header)){
   //do something
            die('sent');
}else{
      die('not sent');
  //do something
}*/
    }


}

?>