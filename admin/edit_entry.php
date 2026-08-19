<?php

if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        $ID = $_REQUEST['ID'];

        $pokemon_name = $_REQUEST['pokemon_name'];
        $pokedex_number = $_REQUEST['pokedex_number'];
        $generation = $_REQUEST['generation'];
        $primary_type = $_REQUEST['primary_type'];

        // This may be blank
        $secondary_type = $_REQUEST['secondary_type'] ?? "";

        $evolution_stage = $_REQUEST['evolution_stage'];
        $ability = $_REQUEST['ability'];
        $speed = $_REQUEST['speed'];
        $description = $_REQUEST['description'];


        /*
        NULLIF turns an empty secondary type into SQL NULL.

        Example:
        NULLIF('', '') = NULL
        NULLIF('5', '') = 5
        */

        $stmt_edit = $dbconnect->prepare(
            "UPDATE pokemon
            SET
                Pokemon_Name = ?,
                Pokedex_Number = ?,
                GenerationID = ?,
                PrimaryTypeID = ?,
                SecondaryTypeID = NULLIF(?, ''),
                EvolutionStageID = ?,
                AbilityID = ?,
                Speed = ?,
                Description = ?
            WHERE PokemonID = ?"
        );


        $stmt_edit->bind_param(
            "siiisiiisi",
            $pokemon_name,
            $pokedex_number,
            $generation,
            $primary_type,
            $secondary_type,
            $evolution_stage,
            $ability,
            $speed,
            $description,
            $ID
        );


        $stmt_edit->execute();

        $stmt_edit->close();


        // Show updated Pokémon
        $heading = "Edit Pokémon Success";

        $help_text = "";

        $params = [$ID];

        $sql_condition = "WHERE p.PokemonID = ?";

        include("content/results.php");

    }

}

else {

    $login_error = urlencode(
        'Please login to access this page'
    );

    header(
        "Location: index.php?page=admin/login&error=$login_error"
    );

    exit;
}

?>