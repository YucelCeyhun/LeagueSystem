<?php
//control empty,tag
function CheckInput($input){
    $input = trim(strip_tags($input));
    return empty($input);
}

function StripInput($input){
    $input = trim(strip_tags($input));
    return $input;
}

?>