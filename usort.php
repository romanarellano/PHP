<?php

// Arrays can hold arrays, those can hold arrays, and so on.
$my_array = array(
  'George' => array(
    'birthyear' => 1972,
    'fav_band' => 'The Cure',
    'shoe_size' => 10,
  ),
  'Sally' => array(
    'birthyear' => 1975,
    'fav_band' => 'Coldplay',
    'shoe_size' => 8,
  ),
  'Deepak' => array(
    'birthyear' => 1969,
    'fav_band' => 'Beach Boys',
    'shoe_size' => 10,
  ),
);

// Adding an item to a multidimensional array.
$my_array['Lucy'] = array(
  'birthyear' => 1984,
  'fav_band' => 'The Beatles',
  'shoe_size' => 9,
);

usort($my_array,function($a,$b){
  return $a['birthyear'] - $b['birthyear'];

});


//var_dump($my_array);


$youngest_person = array_pop($my_array);
var_dump($youngest_person['fav_band']);