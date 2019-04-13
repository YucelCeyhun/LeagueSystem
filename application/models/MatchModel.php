<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MatchModel extends CI_Model
{
   public function GetMatchAsRow($matchIndex){
        $status = Array(
          'mId' => $weekIndex  
        );
       $row = $this->db->where($status)->get('matches')->row();
       return $row;
   }

   public function UpdateMatch($matchIndex,$matchArray){
        $status = Array(
            'mId' => $matchIndex
        );

        if($this->db->where($status)->update('matches',$matchArray)){
            return true;
        }
        return false;
    }

   public function ZeroMatchesData(){
      $array = Array(
         'teamHostId' => 0,
         'teamGuestId' => 0,
         'teamHostPoint' => 0,
         'TeamGuestPoint' => 0
      );
      $this->db->update('matches',$array);
   }

   public function GetMatchAsRowWithTeam($matchIndex){
      $status = Array(
         'matches.mId' => $matchIndex  
      );
      $row = $this->db->where($status)->get('matches')->row();

      return $row;

   }

}

