<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fourthweekrate
{
    public function GetRate($WeekCombination,$league)
    {
        $combin = [0,1,2,3,4,6];
        
        for($i = 3;$i>=0;$i--){
            $diff = $league[0]->point - $league[$i]->point;
            if($diff > 6){
                $chance = 0;
            }else if($diff > 4 && $i != 1){
                if((in_array([$league[0]->id,$league[1]->id],$WeekCombination[0]) || in_array([$league[1]->id,$league[0]->id],$WeekCombination[0]) ||
                in_array([$league[0]->id,$league[1]->id],$WeekCombination[1]) || in_array([$league[1]->id,$league[0]->id],$WeekCombination[1])) &&
                ($league[0]->point - $league[1]->point <= 2 && $league[$i]->point != $league[1]->point)){
                    $chance = 0;
                }else{
                    $chance = 1/count($combin)*1/count($combin);
                }
            }else if($diff > 4){
                $chance = 1/count($combin)*1/count($combin);
            }else{

                $key = array_search($diff, $combin);
                if($key != 0 && $i != 0){
                    $chance = $this->ChanceCalculator($combin,$key);
                }else if($league[0]->point == $league[3]){
                    $chance = 0.25;
                }else{
                    if($i == 0 && $league[0]->point != $league[1]->point)
                        $diffPlus = $league[0]->point - $league[1]->point;
                    if($league[0]->point == $league[1]->point && ($i == 0 || $i == 1) && $league[0]->point != $league[2]->point)
                        $diffPlus = $league[0]->point - $league[2]->point;
                    if($league[0]->point == $league[2]->point && ($i != 3) && $league[0]->point != $league[3]->point) 
                        $diffPlus = $league[0]->point - $league[3]->point;

                    $keyPlus = array_search($diffPlus, $combin);
                    if($diffPlus > 6){
                        $chance = 1;
                    }else{
                        if(!$keyPlus || $keyPlus == 5){
                            $chance = 1-(1/count($combin)*1/count($combin));
                        }else{
                           $chance = $this->ChanceCalculatorForFirst($combin,$keyPlus);
                        }
                    }
                } 
            }

            $vals[] = Array(
                'team' => $league[$i]->name,
                'chance' => $chance
            );
        }   

        $rate = $this->RateCalculator($vals);

        return $rate;
    }

    private function ChanceCalculatorForFirst($combin,$key){

        if($key < 3){
            $chance = (1/6*($key));
            $backStep = 1;
            for($i=$key;$i<=(count($combin)-1);$i++){
                $chance += 1/6*((6-$backStep)/6);
                $backStep++;
            }
            $backStep++;
            $chance += 1/6*(6-$backStep)/6;
            $chance= $chance;
        }else{
            $chance = (1/6*($key));
            $backStep = 1;
            for($i=$key;$i<=count($combin)-1;$i++){
                $chance += 1/6*((6-$backStep)/6);
                $backStep++;
            } 

        }

        return $chance;
    }

    private function ChanceCalculator($combin,$key){
        $chance = 0;
        for($i=1;$i<count($combin)-$key;$i++){
            $chance += (1/6*$i/6);
        }

        return $chance;
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

}
