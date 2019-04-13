<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Matchconverter
{
    public function DynamicMatchTable($matchIndex)
    {
        
        $CI =& get_instance();
        $CI->load->model('matchmodel');
        $CI->load->model('leaguemodel');

        $matchOdd = $CI->matchmodel->GetMatchAsRowWithTeam($matchIndex+1);
        $matchEven = $CI->matchmodel->GetMatchAsRowWithTeam($matchIndex+2);

        $matchOddHost = $CI->leaguemodel->GetTeamAsRow($matchOdd->teamHostId);
        $matchOddGuest = $CI->leaguemodel->GetTeamAsRow($matchOdd->teamGuestId);
        $matchEvenHost = $CI->leaguemodel->GetTeamAsRow($matchEven->teamHostId);
        $matchEvenGuest = $CI->leaguemodel->GetTeamAsRow($matchEven->teamGuestId);

        $listRepository = '<table class="table">
        <tr>
            <td width="42%" class="text-center">'.$matchOddHost->name.'</td>
            <td class="text-center">'.$matchOdd->teamHostPoint.' - '.$matchOdd->teamGuestPoint.'</td>
            <td width="42%" class="text-center">'.$matchOddGuest->name.'</td>
        </tr>
        <tr>
            <td width="42%" class="text-center">'.$matchEvenHost->name.'</td>
            <td class="text-center">'.$matchEven->teamHostPoint.' - '.$matchEven->teamGuestPoint.'</td>
            <td width="42%" class="text-center">'.$matchEvenGuest->name.'</td>
        </tr>
      </table>
            ';

        return $listRepository;

    }

}


/*

            */