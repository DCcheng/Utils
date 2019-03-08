<?php
	include_once dirname(__FILE__)."/htmldom/simple_html_dom.php";
	
	class HtmldomUtils{

		function loadUrlHtml($url){
			return file_get_html($url);
		}

		function loadStrHtml($str){
			return str_get_html($str);
		}
	}
?>