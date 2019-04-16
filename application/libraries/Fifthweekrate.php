<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fifthweekrate
{

    public function GetRate($WeekCombination,$league)
    {
        for($i = 3;$i>=0;$i--){
                if($i == 0){
                    $diff = $league[0]->point - $league[1]->point;
                    if($diff > 3){
                        $chance = 1;
                    }else {
                        $gd = $league[0]->goalDifference - $league[1]->goalDifference;
                        $gdRateFirst = $this->GoalDiffRateEffect($gd);
                        $opponent = $this->TeamOpponent($league[0]->id,$league,$WeekCombination);
                        $chance = $this->FirstWinRate($diff,$opponent,$gd,$gdRateFirst);
                    }
                }

                if($i != 0){
                    $diff = $league[0]->point - $league[$i]->point;
                    if($diff > 3){
                        $chance = 0;
                    }else{
                        $gd = $league[$i]->goalDifference - $league[0]->goalDifference;
                        $gdRateOthers = $this->GoalDiffRateEffect($gd);
                        $opponent = $this->TeamOpponent($league[$i]->id,$league,$WeekCombination);
                        $chance = $this->OthersWinRate($diff,$opponent,$gd,$gdRateOthers,$i,$league);
                    }
                }

            $vals[] = Array(
                'team' => $league[$i]->name,
                'chance' => $chance
            );

        }
    
        $rate = $this->RateCalculatorSecond($vals);
        return $rate;
    }



    private function RateCalculator($array){
        $total = 0;
        foreach($array as $list){
            $total += $list['chance'];
        }

        for($i = 0;$i<count($array);$i++){
            $array[$i]['chance'] /= $total;
            $array[$i]['chance'] *= 100;
            $array[$i]['chance'] = round($array[$i]['chance']);
        }

        return $array;
    }

    private function Fac($num){
        $fac = 1;
        if($num < 1)
            $num = 1;

        for($i=1;$i<=$num;$i++){
            $fac *=$i;
        }

        return $fac;
    }

    private function TeamOpponent($targetTeamId,$league,$WeekCombination){
        $key = array_search($targetTeamId, $WeekCombination[0][0]);
        if($key == false){
            $key = array_search($targetTeamId, $WeekCombination[0][1]);
            if($key == 0){
                $opponent = $WeekCombination[0][1][1];
            }else{
                $opponent = $WeekCombination[0][1][0];
            }
        }else{
            if($key == 0){
                $opponent = $WeekCombination[0][1][1];
            }else{
                $opponent = $WeekCombination[0][1][0];
            }
        }
        for($i = 3;$i>=0;$i--){
            if($league[$i]->id == $opponent){
                return $i;
            }
        }
        return $opponent;
    }

    private function GoalDiffRateEffect($gd){
        $gdAbs = abs($gd);
        $gdChance = (pow(0.1,$gdAbs)*pow(0.9,(10-$gdAbs))*($this->Fac(10))/($this->Fac($gdAbs)*$this->Fac(10-$gdAbs)));

        if($gd > 0)
            $gdChance = 1-$gdChance;

        return $gdChance;
    }

    private function FirstWinRate($diff,$opponent,$gd,$gdRateFirst){

        if($opponent == 1 && $diff != 3){
            $chance = 2/3;
        }else if($diff == 0){
           $chance = (1/3*$gdRateFirst)+1/3;
        }else if($diff == 1){
            if($gd < 10){
                $chance = (1/9*$gdRateFirst)+2/3;
            }else{
                $chance = 7/9;
            }
        }else if($diff == 2){
            if($gd < 10){
                $chance = (1/9*$gdRateFirst)+7/9;
            }else{
                $chance = 8/9;
            }
        }else if($opponent == 1 && $diff = 3){
            if($gd < 0){
                $chance = 2/3;
            }else{
                $gd = ceil($gd/2);
                $gdRateFirst = $this->GoalDiffRateEffect($gd);
                $chance =2/3+(1/3*$gdRateFirst);
            }
        }else{

            if($gd <= 0){
                $chance = 8/9;
            }else  if($gd < 10 && $gd > 0){
                $chance = (1/9*$gdRateFirst)+8/9;
            }else{
                $chance = 1;
            }
        }

        return $chance;
    }

    private function OthersWinRate($diff,$opponent,$gd,$gdRateOthers,$order,$league){

        if($opponent == 0 && $diff != 3){
            if($order == 1){
                $chance = 1/3;
            }else{
                $otherDiff = $league[1]->ponit - $league[$order]->point;
                if($otherDiff > 1){
                    $gdOther = $this->GoalDiffRateEffect(-$otherDiff);
                    $chance = (1/9*$gdOther)+1/9;
                }
            }
        }else if($diff == 0){
            $chance = (1/3*$gdRateOthers)+1/3;
        }else if($diff == 1){
            if($gd < 10){
                $chance = ((1/9*$gdRateOthers)+2/9);
            }else{ 
                $chance = 2/9;
            }
        }else if($diff == 2){
            if($gd < 10){
                $chance = ((1/9*$gdRateOthers)+1/9);
            }else{ 
                $chance = 1/9;
            }
        }else if($opponent == 0 && $diff = 3){
            if($gd > 0){
                $chance = 1/3;
            }else{
                $gd = ceil($gd/2);
                $gdRateOthers = $this->GoalDiffRateEffect($gd);
                $chance = 1/3*$gdRateOthers;
            }
        }else{
            if($gd >= 0){
                $chance = 1/9;
            }else if($gd < 0 && $gd > -10){
                $chance = 1/9*$gdRateOthers;
            }else{
                $chance = 0;
            }
        }

        return $chance;
    }

    private function RateCalculatorSecond($array){
        $total = 0;
        foreach($array as $list){
            $total += $list['chance'];
        }

        for($i = 0;$i<count($array);$i++){
            
            $array[$i]['chance'] /= $total;
            $array[$i]['chance'] *= 100;
           
            $array[$i]['chance'] = $i == 3 ? floor($array[$i]['chance']) : ceil($array[$i]['chance']);
            
        }

        return $array;
    }



}
