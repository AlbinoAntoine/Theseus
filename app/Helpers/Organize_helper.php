<?php

function findUser_name($id_user){
    $UsersModel = new \Modules\Auth\Models\UsersModel();
    $User = $UsersModel -> find($id_user);
    if (!empty($User)){
        return $User->Nom.' '.$User->Prenom;
    }else{
        return 'Unknown User';

    }
}

function limitString($string, $length){
    helper('text');
    if (strlen($string)>$length){
        return character_limiter($string, $length);
    }else{
        return $string;
    }
}

function time_to_hm($str_time){

    //$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    if ($minutes < 10) $minutes = '0' . $minutes;
    if ($hours < 10) $hours = '0' . $hours;
    return $hours .':'. $minutes ;
}

function get_ppUser($id_user){
    $fileName =  "pp_" . $id_user;
    $extention = ".jpg";
    if (file_exists(PP_DIR . $fileName . ".jpg")) {
        $extention = ".jpg";
    } elseif(file_exists(PP_DIR . $fileName . ".png")){
        $extention = ".png";
    }else{
        $fileName = "pp_default";
    }
    return '<img src="' . base_url(PP_URL).'/'. $fileName . $extention . '" alt="Profile picture">';
}

function check_darkmode($info_dark){
    if (!empty($info_dark) || $info_dark == 1){
        return 'dark-mode';
    }
}