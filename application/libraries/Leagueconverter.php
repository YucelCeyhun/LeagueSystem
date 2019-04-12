<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Leagueconverter
{
    public function DynamicLeagueTable()
    {
        
        $CI =& get_instance();
        $CI->load->model('leaguemodel');

        $index = 1;
        $tableRepository = '<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Team</th>
            <th scope="col">PTS</th>
            <th scope="col">P</th>
            <th scope="col">W</th>
            <th scope="col">D</th>
            <th scope="col">L</th>
            <th scope="col">GD</th>
            </tr>
        </thead>
        <tbody>';

        $result = $CI->leaguemodel->GetTeamsAsArray();
        foreach($result as $team){
            $num = $CI->leaguemodel->GetTeamMatches($team->id);
            $tableRepository .= '
            <tr team-data="'.$team->id.'" data-target="#GeneralModal" data-toggle="modal">
            <th scope="row">'.$index.'</th>
            <td>'.$team->name.'</td>
            <td>'.$team->point.'</td>
            <td>'.$num.'</td>
            <td>'.$team->win.'</td>
            <td>'.$team->drawn.'</td>
            <td>'.$team->lost.'</td>
            <td>'.$team->goalDifference.'</td>
            </tr>
            ';
            $index++;
       }

        $tableRepository .= '</tbody></table>';

        return $tableRepository;

    }

}
