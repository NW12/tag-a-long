<?php

class Web_Config

{

	public function __construct()

	{



	}

	public function setSiteConfig(){

		$ci = &get_instance();		

		$table = 'site_settings';

		$ci->db->select ("*");

		$ci->db->order_by ('id','desc');

               // $ci->db->limit (1);

		$q = $ci->db->get ( $table );

		if ($q->num_rows () > 0) {

			foreach ( $q->result_array () as $row ) {

				define(strtoupper($row['option_name']) , $row['option_value']);

			}

		}

	}

}

?>