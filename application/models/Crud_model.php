<?php

/*
----------------------------
CRUD     ----    MODEL
----------------------------
*/

class Crud_model extends CI_Model {

    function __construct() {

        parent::__construct();

    }



    function getRow($where, $table)

    {

        $query = $this->db->get_where($table, $where);

        if ($query->num_rows()>0)

        {

            return $query->row_array();

        }

        

    }//End get_row

    

    public function getArray($table){



        $query = $this->db->get($table);

        return $query->result_array();



    }//End getArray

    public function getordersbyuserid($id) {



      $uid = $this->session->userdata('id'); 

      $this->db->select("orders.*, (sum(orders.product_total)) as total_amount,  sum(orders.quantity) as qty, products.name, users.first_name, users.last_name, order_status.name as order_status");

      $this->db->from('orders');

      $this->db->join('products as products', 'products.product_id = orders.product_id','left');  

      $this->db->join('users as users', 'users.id = orders.customer_id', 'left'); 		 

      $this->db->join('order_status as order_status', 'order_status.id = orders.order_status', 'left'); 

      $this->db->where('orders.customer_id', $id);

      $this->db->where('orders.is_active', 1);					

      $this->db->group_by("orders.order_no");

      $this->db->order_by("orders.order_no", "desc");

      $query = $this -> db -> get()->result_array();

      return $query;

  }






  public function addCart(){



    $qty = 1;

    if($this->input->post()){



     $qty = $this->input->post('qty');

 }

 $insert_data = array( 'id' => $query->id,

    'name' => $query->product_name,

    'price' => $price,

    'qty' => $qty,

    'options' => array('descriptioni' => $query->short_description, 'Color' => 'Red')

    );


 $insert = $this->cart->insert($insert_data);


 return $insert;



    }//End addCart

    

    public function getProducts($cat_slug='', $product_slug=''){

        $this -> db -> select('p.id, p.product_name, p.long_description, cat.cat_slug, p.product_cost, p.product_price, p.discount, p.p_slug');

        $this->db->from('products as p');

        $this->db->join('categories as cat', 'cat.id=p.category_id');

        if($product_slug !=''){

            $this -> db -> where('p.p_slug', $product_slug);

        }elseif($cat_slug !=''){

            $this -> db -> where('cat.cat_slug', $cat_slug);

        }{

            $this -> db -> order_by('p.id', 'DESC');

        }

        $query = $this->db->get();

        //echo $this -> db ->last_query();

        return $query->result_array();



    }//End getProducts



    public function getSearchProducts($product_slug=''){



     $this->db->select('p.id, p.product_name, cat.cat_slug, p.product_cost, p.product_price, p.discount, p.p_slug');

     $this->db->from('products as p');

     $this->db->join('categories as cat', 'cat.id=p.category_id');

     if($product_slug !=''){

        $this->db->like('p.product_name', $product_slug);

        $this->db->or_like('p.p_slug', $product_slug);

        $this->db->or_like('cat.name', $product_slug);

    }

    $this -> db -> order_by('p.id', 'DESC');

    $query = $this->db->get();

        //echo $this -> db ->last_query();

    return $query->result_array();



    }//End getSearchProducts

    

    public function insertData($insertdata, $table){

        $insert_new = $this->db->insert($table, $insertdata);

        return $insert_new;

    }



    public function insertDatauser($insertdata, $table){

        $insert_new = $this->db->insert($table, $insertdata);

        return $this->db->insert_id();

    }



    public function updateData($updatedata, $table, $where){

        $this -> db -> where($where);

        $update_new = $this->db->update($table, $updatedata) or die();

        return $update_new;

    }



    public function record_count($table) {

        return $this->db->count_all($table);

    }

}