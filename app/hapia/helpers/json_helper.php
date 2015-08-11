<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('isJson')){
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if ( ! function_exists('prettyJson')){
    function prettyJson($json, $html = FALSE) {
        $json_formated = '';
        if (version_compare(PHP_VERSION, '5.4', '>=')){
            $json_formated = json_encode($json, JSON_PRETTY_PRINT);
        }else{
            $result = '';
            $level = 0;
            $in_quotes = false;
            $in_escape = false;
            $ends_line_level = NULL;
            $json_length = strlen( $json );
        
            for( $i = 0; $i < $json_length; $i++ ) {
                $char = $json[$i];
                $new_line_level = NULL;
                $post = "";
                if( $ends_line_level !== NULL ) {
                    $new_line_level = $ends_line_level;
                    $ends_line_level = NULL;
                }
                if ( $in_escape ) {
                    $in_escape = false;
                } else if( $char === '"' ) {
                    $in_quotes = !$in_quotes;
                } else if( ! $in_quotes ) {
                    switch( $char ) {
                        case '}': case ']':
                            $level--;
                            $ends_line_level = NULL;
                            $new_line_level = $level;
                            break;
        
                        case '{': case '[':
                            $level++;
                        case ',':
                            $ends_line_level = $level;
                            break;
        
                        case ':':
                            $post = " ";
                            break;
        
                        case " ": case "\t": case "\n": case "\r":
                            $char = "";
                            $ends_line_level = $new_line_level;
                            $new_line_level = NULL;
                            break;
                    }
                } else if ( $char === '\\' ) {
                    $in_escape = true;
                }
                if( $new_line_level !== NULL ) {
                    $result .= "\n".str_repeat( "\t", $new_line_level );
                }
                $result .= $char.$post;
            }
            $json_formated = $result;
        }
        if($html === TRUE){
            $json_formated = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $json_formated);
            $json_formated = str_replace("\n", '<br />', $json_formated);
        }
        return $json_formated;
    }
}
if ( ! function_exists('json_encode_UNESCAPED_UNICODE')){
    function json_encode_UNESCAPED_UNICODE($json) {
        if (version_compare(PHP_VERSION, '5.4', '>=')){
            return json_encode($json, JSON_UNESCAPED_UNICODE);
        }else{
            return preg_replace_callback('/(?<!\\\\)\\\\u(\w{4})/', function ($matches) {
                return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
            }, json_encode($json));
        }
    }
}