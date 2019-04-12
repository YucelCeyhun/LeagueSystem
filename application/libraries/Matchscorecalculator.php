<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Matchscorecalculator
{
    const HOST_EFFECT = 5;
    const MAIN_GOAL_CHANCE = 10;
    const ITERATION_COUNT = 10;

    public function ResultMatchSore($matchId,$match)
    {
        
        $CI =& get_instance();
        $CI->load->model('matchmodel');
        $result = $this->ScoreCalculator($matchId,$match);
        $data = Array(
            'teamHostId' => $match[0],
            'teamGuestId' => $match[1],
            'teamHostPoint' => $result['hostGoal'],
            'teamGuestPoint' => $result['guestGoal']
        );

        $CI->matchmodel->UpdateMatch($matchId,$data);
        $score = $result['hostGoal'] - $result['guestGoal'];
 

       $this->PointCalculater($score,$match[0]);
       $this->PointCalculater(-$score,$match[1]);
        
    }

    private function ScoreCalculator($matchId,$match){
        $CI =& get_instance();
        $CI->load->model('leaguemodel');
        $hostTeam = $CI->leaguemodel->GetTeamAsRow($match[0]);
        $guestTeam = $CI->leaguemodel->GetTeamAsRow($match[1]);
        $hostGoal = $this->GoalCalculator($hostTeam,$guestTeam,TRUE);
        $guestGoal = $this->GoalCalculator($guestTeam,$hostTeam,FALSE);

        return Array(
            'hostGoal' => $hostGoal,
            'guestGoal' => $guestGoal
        );
    }

    private function GoalCalculator($targetTeam,$otherTeam,$isHost){
        $goal=0;
        for($i=1;$i<= self::ITERATION_COUNT;$i++){
            $rand = rand(0,100);
            $chance = self::MAIN_GOAL_CHANCE+$targetTeam->offensive-$otherTeam->defensive;
            $chance =  $isHost ? $chance + self::HOST_EFFECT : $chance - self::HOST_EFFECT;
            $chance < 1 ? $chance = 1: null;
            $chance > 80 ? $chance = 80 + round(log(exp(1),$chance)): null;

            if($chance >= $rand)
                $goal++;
        }

        return $goal;
    }

    private function PointCalculater($score,$teamId){
        $CI =& get_instance();
        $CI->load->model('leaguemodel');
        $row = $CI->leaguemodel->GetTeamAsRow($teamId);
        
        if($score > 0){
            $array = Array(
                'point' => $row->point + 3,
                'win' => $row->win + 1,
                'goalDifference' => $row->goalDifference + $score
            );
        }else if($score == 0){
            $array = Array(
                'point' => $row->point + 1,
                'drawn' => $row->drawn + 1,
                'goalDifference' => $row->goalDifference + $score
            );
        }else{
            $array = Array(
                'lost' => $row->lost + 1,
                'goalDifference' => $row->goalDifference + $score
            );
        }

        $CI->leaguemodel->UpdateTeamData($teamId,$array);

    }

}
