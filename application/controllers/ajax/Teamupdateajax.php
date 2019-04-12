<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Teamupdateajax extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

	public function index()
	{

        if ($this->input->is_ajax_request()) {

            $teamId = StripInput($this->input->post('teamId'));
            $team = StripInput($this->input->post('team'));
            $offensive = StripInput($this->input->post('offensive'));
            $defensive = StripInput($this->input->post('defensive'));

            $this->form_validation->set_message(
                array(
                    "required"      => "{field} Gerekli alanları doldurun",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "greater_than_equal_to" => "{field} {param}' dan az olamaz",
                    "alpha_numeric_spaces" => "{field} sayı ve harfden oluşablir",
                    "is_natural_no_zero" => "{field} 1 dan küçük olamaz ve 100den büyük olamaz",
                    "max_length" => "{field} {param}'dan fazla karakter içeremez"
                )
            );

            $this->form_validation->set_rules("teamId", "Team Id", "trim|numeric|greater_than_equal_to[1]|required");
            $this->form_validation->set_rules("team", "Team", "trim|alpha_numeric_spaces|required");
            $this->form_validation->set_rules("offensive", "Atak", "trim|is_natural_no_zero|required|max_length[3]|less_than_equal_to[100]");
            $this->form_validation->set_rules("defensive", "Savunma", "trim|is_natural_no_zero|required|max_length[3]|less_than_equal_to[100]");

            if ($this->form_validation->run()) {
                $this->load->model('leaguemodel');
                $array = Array(
                    'name' => $team,
                    'offensive' => $offensive,
                    'defensive' => $defensive
                );

                if($this->leaguemodel->UpdateTeamData($teamId,$array)){

                    $this->load->library('Leagueconverter');
            
                    $returnedVal = Array(
                        'situation' => 1,
                        'val' => $this->leagueconverter->DynamicLeagueTable(),
                        'msg' => 'Güncelleme Başarılı'
                    );
                }
            }else{
                $returnedVal = Array(
                    'situation' => -1,
                    'msg' => validation_errors()
                );
            }
            echo json_encode($returnedVal);
        }
    }
 
}