<?php
function strtr_utf8($str, $from, $to) {
    $keys = array();
    $values = array();
    preg_match_all('/./u', $from, $keys);
    preg_match_all('/./u', $to, $values);
    $mapping = array_combine($keys[0], $values[0]);
    return strtr($str, $mapping);
}
$this->module("translit")->extend([
    'compile' => function($str, $reverse = false) use($app) {
        $rus = array('ё','ж','ц','ч','ш','щ','ю','я','Ё','Ж','Ц','Ч','Ш','Щ','Ю','Я');
        $lat = array('yo','zh','tc','ch','sh','sh','yu','ya','YO','ZH','TC','CH','SH','SH','YU','YA');
        $rus2 = "АБВГДЕЗИЙКЛМНОПРСТУФХЪЫЬЭабвгдезийклмнопрстуфхъыьэ";
        $lat2 = "ABVGDEZIJKLMNOPRSTUFH_I_Eabvgdezijklmnoprstufh_i_e";
      	
      	if (!$reverse) {
            $str = str_replace($rus, $lat, $str);
            $str = strtr_utf8($str, $rus2, $lat2);
        } else {
            $str = str_replace($lat, $rus , $str);
            $str = strtr_utf8($str, $lat2, $rus2);
        }
        return $str;
    },
  	'compare' => function($str, $translit) use($app) {
      	$str = cockpit('translit')->compile($str);
      	return $str==$translit;
    }
]);

if (!function_exists('translit')) {
    function translit($str, $reverse = false) {
      	return cockpit('translit')->compile($str, $reverse);
    }
}
?>