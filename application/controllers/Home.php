<?php
/*
*basit bir yapıcı metod ile home conent ve footer view leri çağırdık
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->view("Homeheader");
		$this->load->view("Homecontent");
		$this->load->view("Homefooter");
		
	}
	
	public function index()
	{

	}
}
