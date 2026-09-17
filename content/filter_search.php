<?php

// Default order
$order = " ORDER BY p.Pokemon_Name ASC";

$help_text = "";


// Retrieve filter values
$generationID = $_REQUEST['generation'] ?? "";
$primaryTypeID = $_REQUEST['primary_type'] ?? "";
$secondaryTypeID = $_REQUEST['secondary_type'] ?? "";
$evolutionStageID = $_REQUEST['evolution_stage'] ?? "";
$abilityID = $_REQUEST['ability'] ?? "";


// Blank filters should match everything
$all_input = [

    $generationID,
    $primaryTypeID,
    $secondaryTypeID,
    $evolutionStageID,
    $abilityID

];


foreach ($all_input as $index => $value) {

    if ($value === "") {

        $all_input[$index] = "%%";

    }
}


list(
    $generationID,
    $primaryTypeID,
    $secondaryTypeID,
    $evolutionStageID,
    $abilityID

) = $all_input;


// Heading
$heading = "Filter Results...";


// Filter query
$sql_condition = "

    WHERE p.GenerationID LIKE ?

    AND p.PrimaryTypeID LIKE ?

    AND (
        p.SecondaryTypeID LIKE ?
        OR (
            p.SecondaryTypeID IS NULL
            AND ? = '%%'
        )
    )

    AND p.EvolutionStageID LIKE ?

    AND p.AbilityID LIKE ?

";


$params = [

    $generationID,
    $primaryTypeID,

    $secondaryTypeID,
    $secondaryTypeID,

    $evolutionStageID,
    $abilityID

];


$help_text = "Results show Pokémon which match ALL the filters you chose. If there are no results, try using fewer filters.";


// Alphabetical order
$sql_condition .= $order;


// Display results
include("results.php");

?>