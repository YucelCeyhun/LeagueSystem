<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class LeagueAjax extends CI_Controller {

	public function index()
	{
        //direkt olarak json formatında GetTeamsAsTable methodundan gelen değerleri gönderiyoruz.
        $this->load->library('Leagueconverter');
        $returnedVal = Array(
            'situation' => 1,
            'val' => $this->leagueconverter->DynamicLeagueTable()
        );

       echo json_encode($returnedVal);
    }
 
}
