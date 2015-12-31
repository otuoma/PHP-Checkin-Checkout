<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_functions extends CI_Model {
    public function mysql_sanitize( $value ) {
        $value = trim($value);
               $magic_quotes_active = get_magic_quotes_gpc();
               $new_enough_php = function_exists( "mysql_real_escape_string" ); 
               if( $new_enough_php ) {
                       if( $magic_quotes_active ) { $value = stripslashes( $value ); }
                       $value = mysql_real_escape_string( $value );
               } else {if( !$magic_quotes_active ) { $value = addslashes( $value ); }
       }
    return $value;
    }
    public function html_sanitize( $value ) {
        $value = trim($value);
        $allowable_tags = "<br>, <b>, <strong>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>, <span>";
        $value = strip_slashes(strip_tags($value, $allowable_tags));
        $value = htmlspecialchars( $value );
        
        
    return $value;
    }
    
}