<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_order extends CI_Model{
 
    private $conn;
 
    // object properties
    public $order_id;
    public $customer_id;
    public $delivery_address;
    public $total;
    
    public $order_detail_id;
    public $product_id;
    public $product_description;
    public $price;
    public $quantity;  
 
    // constructor database connection
   

    function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

    public function readOrders($customer_id,$fecha_inicial,$fecha_final){

        //registros en el rango de fechas y para el cliente
         $query= $this->db->query("SELECT o.creation_date,o.order_id,o.total,o.delivery_address FROM test.order o
                WHERE o.customer_id=".$customer_id." AND o.creation_date>=$fecha_inicial AND o.creation_date<=$fecha_final ORDER BY o.creation_date,o.order_id");       
         if($query->num_rows() > 0){
            return $query->result_array();
        }else{
          return 0;
        }
    }


    public function readOrderDetails($order_id){
    //consulta en la que se agrupa los productos facturados por el cliente y sus cantidades 
        //GROUP_CONCAT  CONCAT_WS

        $query= $this->db->query("SELECT  GROUP_CONCAT(
                 CONCAT_WS(' x ', od.quantity, od.product_description)      
                SEPARATOR ';') as Products
                FROM test.order_detail od 
                WHERE od.order_id=$order_id;");            
        return $query->result();
 
    }

    public function createOrder(){
     
        // query to insert record

         $fecha_actual = date("Y-m-d");
        
        $query1="INSERT into test.order (customer_id, creation_date,delivery_address,total) values (" . $this->customer_id.",'$fecha_actual','". $this->delivery_address ."',". $this->total .")";
        $query=$this->db->query($query1);
        return $query;
         
    }


    public function createrOrderDetails($i){
     
        // query to insert cada uno de los productos de la orden en cuestion

        $query1="INSERT into test.order_detail (order_id,product_id,product_description,price,quantity) values";
        
        $queryaux="(".$this->order_id.",". $this->order_Details[$i]->product_id.",'". $this->order_Details[$i]->product_description."',". $this->order_Details[$i]->price.",". $this->order_Details[$i]->quantity .")";

         $query1.=$queryaux;

         $this->db->query($query1);        
         
    }

     public function ultimaOrder(){
     //encontrar cual fue la ultima orden que se esta insertando
     
        $query=$this->db->query('SELECT MAX(order_id) AS id FROM test.order');
        
         $ultimo= $query->result();
         if($ultimo){
            foreach ($ultimo as  $ultimo_id){
                $id=$ultimo_id->id;
            }

            $this->order_id=$id;
       
         
         }
        }

    }
?>