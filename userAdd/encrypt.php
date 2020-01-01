<?php 
if(!defined('__ZBXE__')) exit();

function addpadding($string, $blocksize = 16)
{
    $len = strlen($string);
    $pad = $blocksize - ($len % $blocksize);
    $string .= str_repeat(chr($pad), $pad);
    return $string;
}

function strippadding($string)
{
    $slast = ord(substr($string, -1));
    $slastc = chr($slast);
    $pcheck = substr($string, -$slast);
    if(preg_match("/$slastc{".$slast."}/", $string)){
        $string = substr($string, 0, strlen($string)-$slast);
        return $string;
    } else {
        return false;
    }
}

function encrypt($string = "", $keystring, $ivstring)
{
    $key = $keystring;;
    $iv = mb_convert_encoding($ivstring, 'UTF-8');

	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, addpadding($string), MCRYPT_MODE_CBC, $iv));
}

function decrypt($string = "", $keystring, $ivstring)
{
    $key = $keystring;;
    $iv = mb_convert_encoding($ivstring, 'UTF-8');

	$string = base64_decode($string);

	return strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv));
}

define('__XE__',true);
require_once($_SERVER["DOCUMENT_ROOT"].'/config/config.inc.php');  //경로정상확인하였습니다.
$oContext = &Context::getInstance();
$oContext->init();

$module_srl = Context::get('module_srl');
$module_name = Context::get('mid');
$pcmobile = Mobile::isMobileCheckByAgent();
$is_logged = Context::get('is_logged');
$logged_info = Context::get('logged_info');
$mng_use = Context::get('manager');
$user_id = $logged_info->user_id;
$user_name = $logged_info->user_name;
$nick_name = $logged_info->nick_name;
$birthday = $logged_info->birthday;
$email_address = $logged_info->email_address;
$member_srl = $logged_info->member_srl;
$is_admin = $logged_info->is_admin;
$userphone = $logged_info->userphone;
$surftype = $logged_info->surftype;
$oContext->close;

$group_list = $logged_info->group_list;
//$now = date("Y-m-d H:i:s");
$now = date("Y-m-d");

$_UserType = "";
if($group_list[1] != ""){
	$_UserType = "0";
}else if($group_list[236] != ""){
	$_UserType = "3";
}else if($group_list[237] != ""){
	$_UserType = "2";
}else if($group_list[238] != ""){
	$_UserType = "1";
}

if($is_logged){
	$usertext = $user_id."|".$user_name."|".$userphone[0]."-".$userphone[1]."-".$userphone[2]."|".$birthday."|".$_UserType."|".$now;
}else{
	$usertext = "||||".$now;
}

$enctext = encrypt($usertext, "qwertyuiopasdfghjklzxcvbnmqwerty", "1234567890123456");

/*<Br>
암호화 : <?=$enctext?>
<Br>
복호화 : <?=decrypt($enctext, "qwertyuiopasdfghjklzxcvbnmqwerty", "1234567890123456")?>

group_list[1] //관리자
group_list[236] //서핑버스관리자
group_list[237] //매니저
group_list[238] //운영자
*/
?>