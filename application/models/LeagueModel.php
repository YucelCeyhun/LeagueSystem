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
}
