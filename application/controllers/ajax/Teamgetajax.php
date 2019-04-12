<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Teamgetajax extends CI_Controller {

	public function index()
	{

        if ($this->input->is_ajax_request()) {

            $teamId = $this->input->post('teamId');
            $teamId = trim(strip_tags($teamId));

            $this->form_validation->set_message(
                array(
                    "required"      => "{field} Gerekli alanları doldurun",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "greater_than_equal_to" => "{field} {param}' dan az olamaz",
                )
            );

            $this->form_validation->set_rules("teamId", "Team Id", "trim|numeric|greater_than_equal_to[1]");

            if ($this->form_validation->run()) {
                $returnedVal = Array(
                    'situation' => 1,
                    'val' => $this->GetTeamData($teamId),
                );

            }else{
                $returnedVal = Array(
                    'situation' => -1,
                    'msg' => validation_errors()
                );
            }

            echo json_encode($returnedVal);
        }
    }
 
	private function GetTeamData($teamId){
        //method model dosyasından team verilerini çekip geriye table repositoryi döndürüyor
        $this->load->model('leaguemodel');
        $row = $this->leaguemodel->GetTeamAsRow($teamId);

        $formValues = '
            <form>
            <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <img src="'.base_url('assets/images/icons/iconTeam.svg').'" title="Team">
                </div>
                <input type="text" class="form-control" id="team" name="team" placeholder="Takımın Adı" value="'.$row->name.'">
            </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <img src="'.base_url('assets/images/icons/iconOffensive.svg').'" title="Offensive">
                    </div>
                    <input type="number" class="form-control" id="offensive" name="offensive" placeholder="Atak Değeri" value="'.$row->offensive.'" min="0" max="100">
                </div>
            </div>
            <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <img src="'.base_url('assets/images/icons/iconDefensive.svg').'" title="Defensive">
                </div>
                <input type="number" class="form-control" id="defensive" name="defensive" placeholder="Defans Değeri"  value="'.$row->defensive.'" min="0" max="100">
            </div>
            </div>
            </form>
        ';

        return $formValues;
	}
}
