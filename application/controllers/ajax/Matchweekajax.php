<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Matchweekajax extends CI_Controller {

    private $_removeIndex;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

	public function index()
	{
       $WeekCombination = $this->input->post("weekCombination");
       $matchId = $this->input->post("matchId");


        if ($this->input->is_ajax_request()) {
            if($this->PlayCurrentMatch($WeekCombination,$matchId)){
                $this->load->library('leagueconverter');
                $this->load->library('matchconverter');
                $returnedVal = Array(
                    'situation' => 1,
                    'valLeague' => $this->leagueconverter->DynamicLeagueTable(),
                    'valMatch' => $this->matchconverter->DynamicMatchTable($matchId),
                    'removeIndex' => $this->_removeIndex
                );
            }else{
                $returnedVal = Array(
                    'situation' => -1,
                    'msg' => 'Beklenmedik Hata'
                );
            }

            echo json_encode($returnedVal);
        }
    }

    private function PlayCurrentMatch($WeekCombination,$matchId){
        $this->load->library('matchscorecalculator');
        $this->load->model('leaguemodel');
        $this->load->model('matchmodel');

        if($matchId == 0){
            $this->leaguemodel->ZeroTeamsData();
            $this->matchmodel->ZeroMatchesData();
        }

        $currentCombine = rand(0,count($WeekCombination)-1);
        $this->_removeIndex = $currentCombine;
        $match1 = $this->matchscorecalculator->ResultMatchSore($matchId+1,$WeekCombination[$currentCombine][0]);
        $match2 = $this->matchscorecalculator->ResultMatchSore($matchId+2,$WeekCombination[$currentCombine][1]);

        return true;
    }

 
}