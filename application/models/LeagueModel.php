<?php
/*
* CI_Model Sınıfıdan kalıtım yapılarak yeni mode oluşturuldu amaç control ile modeli ayırarak MVC kurallarına bağlı kalmak
* 2 method oluşturuldu. 1. method teamleri teams isimli tablodan geitirip büyükten küçüğe sıralama yapıldı ve geriye döndürüldü.
* 2. method ile teamId ye karşılık gelen teamin maç sayısı çekildi.
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class LeagueModel extends CI_Model
{
   public function GetTeamsAsArray(){
      $result = $this->db->order_by('point','DESC')->order_by('goalDifference','DESC')->order_by('name','ASC')->get('teams')->result();
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
   }

   public function ZeroTeamsData(){
      $array = Array(
         'point' => 0,
         'win' => 0,
         'lost' => 0,
         'drawn' => 0,
         'goalDifference' => 0
      );
      $this->db->update('teams',$array);
   }
}
