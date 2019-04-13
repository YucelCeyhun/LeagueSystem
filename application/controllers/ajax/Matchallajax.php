<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Matchallajax extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

	public function index()
	{

        if ($this->input->is_ajax_request()) {
            if($this->GetAllMatch()){
                $this->load->library('leagueconverter');
                $returnedVal = Array(
                    'situation' => 1,
                    'val' => $this->leagueconverter->DynamicLeagueTable()
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

    private function GetAllMatch(){
        $matchId = 0;
        $this->load->library('matchscorecalculator');
        $this->load->model('leaguemodel');
        $this->leaguemodel->ZeroTeamsData();

        $WeekCombination[] = [[1,2],[3,4]];
        $WeekCombination[] = [[2,4],[1,3]];
        $WeekCombination[] = [[1,4],[2,3]];
        $WeekCombination[] = [[4,3],[2,1]];
        $WeekCombination[] = [[3,1],[4,2]];
        $WeekCombination[] = [[3,2],[4,1]];

       for($i=1;$i<=6;$i++){
            $currentCombine = rand(0,count($WeekCombination)-1);
            $match1 = $this->matchscorecalculator->ResultMatchSore($matchId+1,$WeekCombination[$currentCombine][0]);
            $match2 = $this->matchscorecalculator->ResultMatchSore($matchId+2,$WeekCombination[$currentCombine][1]);
            unset($WeekCombination[$currentCombine]);
            $WeekCombination = array_values($WeekCombination); 
            $matchId +=2;
        }
            return true;
    }

 
}