<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listado_ordenes extends CI_Controller{
	function __construct()
    {
    	parent::__construct(); 
        $this->load->helper('url');
    }

   public function index()
    {
    	$this->load->view('View_listado_ordenes');

     }

}