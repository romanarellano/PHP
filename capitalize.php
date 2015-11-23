<?php

// See http://php.net/manual/en/ref.strings.php for all string functions. Or Google 'php string functions'.

$variable = "  This is a 
 <strong>string</strong> example.  ";


$variable = ucwords($variable);

$new_variable = str_replace("string","String",$variable );
// Return the date.
//$variable = date('F j, Y', time() - 24*60*60);

print $new_variable; 



?>