<?php

// let's take care of the magic quotes
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
	function GPCStrip($arr)
{
		if (is_array($arr))
{
			foreach ($arr AS $arrKey => $arrVal)
{
				$arr[$arrKey] = GPCStrip($arrVal);
}
}
		else if (is_string($arr))
{
			$arr = stripslashes($arr);
}
		return $arr;
}
	$_GET = GPCStrip($_GET);
	$_POST = GPCStrip($_POST);
	$_COOKIE = GPCStrip($_COOKIE);
	if (is_array($_FILES))
{
		foreach ($_FILES AS $key => $val)
{
			$_FILES[$key]['tmp_name'] = str_replace('\\', '\\\\', $val['tmp_name']);
}
}
	$_FILES = GPCStrip($_FILES);
}
if (function_exists('set_magic_quotes_runtime'))
{
	set_magic_quotes_runtime(0);
}

?>