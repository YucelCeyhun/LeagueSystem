<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MatchModel extends CI_Model
{
   /*public function GetTeamsAsArray(){
      $result = $this->db->order_by('point','DESC')->get('teams')->result();
      return $result;
   }

   public function GetTeamMatches($teamId){
      $status = Array(
         'teamHostId' => $teamId,
         'teamGuestId' => $teamId
      );
      $num = $this->db->or_where($status)->get('matches')->num_rows();
      return $num;
   }

   public function GetTeamAsRow($teamId){
      $status = Array(
         'id' => $teamId
      );
      $row = $this->db->where($status)->get('teams')->row();
      return $row;
   }

   
   public function UpdateTeamData($teamId,$array){
      $status = Array(
         'id' => $teamId
      );
      
      if($this->db->where($status)->update('teams',$array))
         return true;

      return false;
   }*/

   public function GetMatchAsRow($weekIndex){
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
}
