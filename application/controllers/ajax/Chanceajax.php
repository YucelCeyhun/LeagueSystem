<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Chanceajax extends CI_Controller {



    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

	public function index()
	{
        if ($this->input->is_ajax_request()) {

            $WeekCombination = $this->input->post("weekCombination");
            $matchId = $this->input->post("matchId");
            $weekId = ($matchId / 2)+1;
            $this->load->model('leaguemodel');
            $league = $this->leaguemodel->GetTeamsAsArray();
            
            
            if($weekId == 4){
                $this->load->library('fourthweekrate');
                $rate = $this->fourthweekrate->GetRate($WeekCombination,$league);

                $returnedVal =  Array(
                    'val' => $rate,
                    'situation' => 1
                );
              
            }else if($weekId == 5){
                $this->load->library('fifthweekrate');
                $rate = $this->fifthweekrate->GetRate($WeekCombination,$league);
                $returnedVal =  Array(
                    'val' => $rate,
                    'situation' => 1
                );
            }else{
                $returnedVal =  Array(
                    'situation' => 0
                );
            }

            echo json_encode($returnedVal);
            }


        }

    }


