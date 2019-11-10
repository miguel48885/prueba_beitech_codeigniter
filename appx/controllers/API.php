<?php

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
class Api extends CI_Controller{
	use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }
	public function __construct()
    {
        parent::__construct();       
        $this->__resTraitConstruct();
        $this->load->model('M_order');
    }

       function read_one_get(){

       	$customer_id=$this->get('customer_id');
        $fecha_inicial=$this->get('fecha_inicial');
		$fecha_final=$this->get('fecha_final');
        $results = $this->M_order->readOrders($customer_id,$fecha_inicial,$fecha_final);
         $orders_arr=array();

        if($results){

        	foreach ($results as $result){       	
	        	 $orders_item=array(
	            "creation_date" => $result["creation_date"],
	            "order_id" => $result["order_id"],
	             "total" => $result["total"],
	             "delivery_address"=>$result["delivery_address"],
	            "OrderDetails" => $this->arrayDetalle($result["order_id"])
	             );   

	        	array_push($orders_arr, $orders_item);

        	}        	  

            $this->response(json_encode($orders_arr), 200); 
          
        } 
        else{
            $this->response(json_encode("No record found"), 200);
        }
    }

    public function arrayDetalle($order_id){
		  $result=$this->M_order->readOrderDetails($order_id);

		  if($result){
		  	foreach ($result as $results){
		  		$cadena=$results->Products;
		  	}
		  	return $cadena;   
        } 
        else{
        	return "No hay productos";
        }       
	}

		function create_one_post(){
			$data = json_decode(file_get_contents("php://input"));

			$data=json_decode($data);
			if(
			    !empty($data->customer_id) &&
			    !empty($data->delivery_address) &&
			    !empty($data->total) &&    
			    !empty($data->order_Details) ){

			    // set order property values
			    $this->M_order->customer_id = $data->customer_id;
			    $this->M_order->delivery_address = $data->delivery_address;
			    $this->M_order->total = $data->total;
			    $this->M_order->order_Details = $data->order_Details;
			        
			    $tamano=count($this->M_order->order_Details);
			     
			    if($this->M_order->createOrder()){
			       
			        $this->M_order->ultimaOrder();

			        for ($i=0;$i<$tamano;$i++){                        
			            $this->M_order->createrOrderDetails($i);
			        }			       

			        $this->response("Order was created.", 200);  
			    }			
			    else{ 
			         $this->response("Unable to create Order.", 503);     
			        }      
			}
			    // tell the user data is incomplete
		else{
		 
		}
	}


}
?>