<?php
/*
*ajax islemi gerçekleştirmek için oluşturduğumuz ve CI_Controller dan inherit ettiğimiz Controleller dosyamız
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class LeagueAjax extends CI_Controller {

	public function index()
	{
        //direkt olarak json formatında GetTeamsAsTable methodundan gelen değerleri gönderiyoruz.
        $returnedVal = Array(
            'situation' => 1,
            'val' => $this->GetTeamsAsTable()
        );

       echo json_encode($returnedVal);
    }
 
	private function GetTeamsAsTable(){
        //method model dosyasından team verilerini çekip geriye table repositoryi geriye döndürüyor
        $this->load->model('leaguemodel');
        $index = 1;
        $tableRepository = '<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">PTS</th>
            <th scope="col">P</th>
            <th scope="col">W</th>
            <th scope="col">D</th>
            <th scope="col">L</th>
            <th scope="col">GD</th>
            </tr>
        </thead>
        <tbody>';

        $result = $this->leaguemodel->GetTeamsAsArray();
        foreach($result as $team){
            $num = $this->leaguemodel->GetTeamMatches($team->id);
            $tableRepository .= '
            <tr>
            <th scope="row">'.$index.'</th>
            <td>'.$team->name.'</td>
            <td>'.$team->point.'</td>
            <td>'.$num.'</td>
            <td>'.$team->win.'</td>
            <td>'.$team->drawn.'</td>
            <td>'.$team->lost.'</td>
            </tr>
            ';
            $index++;
       }

        $tableRepository .= '</tbody></table>';

        return $tableRepository;
	}
}
