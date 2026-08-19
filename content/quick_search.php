<?php

// Default order
$order = " ORDER BY p.Pokemon_Name ASC";

$help_text = "";


// Work out which search button was pressed
$search_type_array = [

    "quick_search"     => "quick",
    "play_search"      => "generation",
    "character_search" => "pokemon",
    "death_search"     => "type"

];

$search_type = "quick";

foreach ($search_type_array as $submit_name => $type_value) {

    if (isset($_POST[$submit_name])) {

        $search_type = $type_value;

        break;
    }
}


// Get search term
$search_term = $_REQUEST['quick_search_term'] ?? "";


// Heading
$heading = $search_term;


// Add wildcards for prepared statement
$search_term = '%' . $search_term . '%';


// Generation search
if ($search_type == "generation") {

    // Remove wildcard symbols
    $generation_search = trim($_REQUEST['quick_search_term']);

    // Allow user to type 1, 2, 3 or I, II, III
    $generation_values = [
        "1" => "Generation I",
        "2" => "Generation II",
        "3" => "Generation III",
        "I" => "Generation I",
        "II" => "Generation II",
        "III" => "Generation III"
    ];

    $upper_search = strtoupper($generation_search);

    if (isset($generation_values[$upper_search])) {
        $generation_search = $generation_values[$upper_search];
    }

    $sql_condition = "
        WHERE gen.Generation_Name = ?
    ";

    $params = [$generation_search];
}


// Pokémon name search
elseif ($search_type == "pokemon") {

    $sql_condition = "
        WHERE p.Pokemon_Name LIKE ?
    ";

    $params = [$search_term];
}


// Type search
elseif ($search_type == "type") {

    $sql_condition = "
        WHERE pt.Type_Name LIKE ?
        OR st.Type_Name LIKE ?
    ";

    $params = [
        $search_term,
        $search_term
    ];

    $help_text = "Results include Pokémon with this primary or secondary type.";
}


// Quick Search
else {

    $sql_condition = "
        WHERE p.Pokemon_Name LIKE ?
        OR gen.Generation_Name LIKE ?
        OR pt.Type_Name LIKE ?
        OR st.Type_Name LIKE ?
        OR evo.Evolution_Stage_Name LIKE ?
        OR ab.Ability_Name LIKE ?
        OR p.Description LIKE ?
    ";

    $params = array_fill(0, 7, $search_term);

    $help_text = "Results are based on Pokémon name, generation, type, evolution stage, ability and description.";
}


// Add alphabetical order
$sql_condition .= $order;


// Display results
include("results.php");

?>