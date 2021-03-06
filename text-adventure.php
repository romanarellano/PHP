<?php

/*
 A map of our land.
 
 [ house  ]-[  yard  ]
     |          |
 [ garden ]-[  pond  ]
 
*/

// Initialize session.
start_adventure_session();

//$data = array();
$//log_array = array();

function start_adventure_session() {
  session_start();
  if (!isset($_SESSION['location'])) {
    $_SESSION['location'] = 'house';
    $_SESSION['inventory'] = array();
  }
}

// Process the command that the user inputs.
function run_command($command) {
  global $data;
  global $log_array;
  //global $standard_text;
  
  $global_commands = array('reset', 'wait', 'pick nose');
  
  if (in_array($command, $global_commands)) {
    switch ($command) {
      
      case 'reset':
        session_destroy();
        start_adventure_session();
        $log_array[] = 'You have reset your adventure. Back to square one.';
        return;
      
      case 'wait':
        $log_array[] = 'You wait. What fun.';
        return;
      
      case 'pick nose':
        log_standard_text('bad');
        return;
    }
  }
  
  $command = strtolower($command);
  $commands = $data[$_SESSION['location']]['commands'];
  if (key_exists($command, $commands)) {
    eval($commands[$command]);
  } else {
    log_standard_text('nope');
    $log_array[] = $data[$_SESSION['location']]['description'];
  }
}

// Add some text to the log to display.
function log_standard_text($name) {
  global $log_array;
  global $standard_text;
  
  $log_array[] = $standard_text[$name];
}

// Move where the character is located.
function move_to($place) {
  global $data;
  global $log_array;
  
  $_SESSION['location'] = $place;
  $log_array[] = $data[$place]['description'];
}

// Pick up an object.
function pick_up($object) {
  global $log_array;
  
  if (in_array($object, $_SESSION['inventory'])) {
    $log_array[] = 'Sorry, it looks like you aready have the ' . $object;
  } else {
    $_SESSION['inventory'][] = $object;
    $log_array[] = 'You picked up the ' . $object . '. How exciting!';
  }
}

// Standard text that might be used in multiple places. Centralizing this makes it easier to change.
$standard_text = array(
  'nothing' => "There's nothing of importance here. Move along.",
  'bad' => "Don't do that! What would your mother think?",
  'pain' => "Ouch! That hurt!",
  'nope' => "Sorry, you can't do that.",
);

// Begin arrays of location data. Inlcudes description and possible commands.
$data['house'] = array(
  'description' => "You're in a house. There's a door to the east and a window to the south.",
  'commands' => array(
    'east' => 'move_to("yard");',
    'south' => 'move_to("garden");',
    'look' => '$log_array[] = in_array("Fishing pole", $_SESSION["inventory"]) ? $standard_text["nothing"] : "Hey, there\'s a fishing pole on the ground!";',
    'pick up fishing pole' => 'pick_up("Fishing pole");',
    'jump' => "log_standard_text('pain');",
  ),
);

$data['yard'] = array(
  'description' => "You are in the yard. What a nice tree!",
  'commands' => array(
    'west' => 'move_to("house");',
    'south' => 'move_to("pond");',
    'climb' => '$log_array[] = "You climb the tree. The view is stunning. You climb back down.";',
  ),
);

$data['garden'] = array(
  'description' => "You are in a beautiful garden. Smell the flowers. Witness the ominous clouds.",
  'commands' => array(
    'north' => 'move_to("house");',
    'east' => 'move_to("pond");',
    'smell' => '$log_array[] = "The flowers are dark and wonderful. You get pollen on your nose, but you don\'t know it.";',
  ),
);

$data['pond'] = array(
  'description' => "You are next to a pond. It looks like of green. Or is that brown? Purple?",
  'commands' => array(
    'west' => 'move_to("house");',
    'north' => 'move_to("yard");',
    'use fishing pole' => 'if (in_array("Fishing pole", $_SESSION["inventory"])) { $log_array[] = "You use your fishing pole to get a fish. It looks a little scary, but maybe it will be useful for something later on."; pick_up("Fish"); } else { $log_array[] = "You don\'t have a fishing pole.";}',
  ),
);

// Run a command if the user entered something.
if (isset($_POST['command'])) {
  run_command($_POST['command']);
}

// If nothing the user did added anything to the log, add a description about the current location.
if (count($log_array) < 1) {
  $log_array[] = $data[$_SESSION['location']]['description'];
}

// Render the log as HTML using implode().
$log = '<ul><li>' . implode('</li><li>', $log_array) .'</li></ul>';

// Render the inventory list.
$inventory = '<p>You have nothing in your inventory.</p>';
if (count($_SESSION['inventory']) > 0) {
  $inventory = '<ul><li>' . implode('</li><li>', $_SESSION['inventory']) . '</li></ul>';
}
$inventory = '<h4>Inventory:</h4>' . $inventory;

?>

<h1 style="text-align:center">A simple adventure</h1>
<div style="background:silver;padding:10px;border:5px solid #333;margin-left:100px;margin-right:100px;">
  <div style="padding-bottom:10px;">
    <form action="test.php" method="post" style="margin:0px">
      Your command: <input type="text" name="command" /> <input type="submit" value="Do it" />
    </form>
  </div>
  <div style="background:black;color:green;padding:10px;border:1px solid white;"><?php print $log . $inventory; ?></div>
</div>