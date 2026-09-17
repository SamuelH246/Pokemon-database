<?php

// retrieve search type and term from the URL
$search_type = to_clean($_REQUEST['search_type']);
$search_term = to_clean($_REQUEST['search_term']);

// set up heading and help text for results page
$heading = $search_term;
$help_text = "";

// default order - show Pokémon in Pokédex order
$order = " ORDER BY p.Pokedex_Number ASC";


// Dictionary containing search types and the database columns they use
// The key is the search type passed through the URL
// The value is the column used in the SQL query
$search_columns = [

    "generation" => "gen.Generation_Name",
    "ability" => "ab.Ability_Name",
    "evolution" => "evo.Evolution_Stage_Name",
    "pokemon" => "p.Pokemon_Name"

];


// Parameters for searches that only use one search term
$params = [$search_term];


// Type search needs to check TWO columns:
// Primary type and Secondary type
if ($search_type == "type") {

    $sql_condition = "
        WHERE pt.Type_Name = ?
        OR st.Type_Name = ?
    ";

    // Two ? placeholders means we need two parameters
    $params = [$search_term, $search_term];

}


// Look up the correct column based on the search type
elseif (array_key_exists($search_type, $search_columns)) {

    $column = $search_columns[$search_type];

    // Exact match because these links come directly from database values
    $sql_condition = "WHERE $column = ?";

}


// If the search type is not recognised,
// search by Pokémon name as a fallback
else {

    $sql_condition = "WHERE p.Pokemon_Name = ?";
}


// Add order to the end of the SQL query
$sql_condition .= $order;


// Display the results using the normal results page
include("results.php");

?>