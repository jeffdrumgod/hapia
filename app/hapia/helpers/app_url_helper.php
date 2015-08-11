<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('base_img')){
	/**
	 * retorna url base para a pasta de imagens
	 * @return [string] [url da pasta de imagens da aplicação]
	 */
	function base_img(){
		$CI =& get_instance();
		return $CI->config->slash_item('base_url').$CI->config->slash_item('base_img_url');
	}
}

if ( ! function_exists('base_js')){
	/**
	 * retorna url base para a pasta de javascripts
	 * @return [string] [url da pasta de javascripts da aplicação]
	 */
	function base_js(){
		$CI =& get_instance();
		return $CI->config->slash_item('base_url').$CI->config->slash_item('base_js_url');
	}
}

if ( ! function_exists('base_css')){
	/**
	 * retorna url base para a pasta de arquivos de estilos
	 * @return [string] [url da pasta de arquivos de estilos da aplicação]
	 */
	function base_css(){
		$CI =& get_instance();
		return $CI->config->slash_item('base_url').$CI->config->slash_item('base_css_url');
	}
}

if ( ! function_exists('base_fonts')){
	/**
	 * retorna url base para a pasta de fontes
	 * @return [string] [url da pasta de fontes da aplicação]
	 */
	function base_fonts(){
		$CI =& get_instance();
		return $CI->config->slash_item('base_url').$CI->config->slash_item('base_fonts_url');
	}
}