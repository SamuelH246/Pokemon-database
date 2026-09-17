<?php

// Return five random Pokémon
$sql_condition = "ORDER BY RAND() LIMIT 5";

$params = [];

$heading = "Random";

$help_text = "Press 'Random' again to generate another set of Pokémon.";

include("results.php");

?>