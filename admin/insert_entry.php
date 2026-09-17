<?php

// Check user is logged in
if (isset($_SESSION['admin'])) {

    // Check form was submitted
    if (isset($_REQUEST['submit'])) {

        // Retrieve data from form
        $pokemon_name = $_REQUEST['pokemon_name'];
        $pokedex_number = $_REQUEST['pokedex_number'];
        $generation = $_REQUEST['generation'];
        $primary_type = $_REQUEST['primary_type'];
        $secondary_type = $_REQUEST['secondary_type'];
        $evolution_stage = $_REQUEST['evolution_stage'];
        $ability = $_REQUEST['ability'];
        $speed = $_REQUEST['speed'];
        $description = $_REQUEST['description'];

        // Convert blank secondary type to NULL
        if ($secondary_type === "") {
            $secondary_type = null;
        }

        // Check for duplicate Pokémon
        $params = [$pokemon_name];

        $sql_condition = "
            WHERE p.Pokemon_Name LIKE ?
        ";

        $exists = get_query($dbconnect, $sql_condition, $params);

        $exists_count = $exists[1];


        // Duplicate found
        if ($exists_count > 0) {

            $heading = "Oops!";

            $help_text =
                "We already have an entry for " .
                $pokemon_name .
                ". Here it is...";

            include("content/results.php");

        }

        // No duplicate - add Pokémon
        else {

            $stmt_add = $dbconnect->prepare(
                "INSERT INTO pokemon
                (
                    Pokemon_Name,
                    Pokedex_Number,
                    GenerationID,
                    PrimaryTypeID,
                    SecondaryTypeID,
                    EvolutionStageID,
                    AbilityID,
                    Speed,
                    Description
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );


            // SecondaryTypeID can be NULL
            $stmt_add->bind_param(
                "siiiiiiis",
                $pokemon_name,
                $pokedex_number,
                $generation,
                $primary_type,
                $secondary_type,
                $evolution_stage,
                $ability,
                $speed,
                $description
            );


            $stmt_add->execute();

            $pokemonID = $dbconnect->insert_id;

            $stmt_add->close();


            // Retrieve newly added Pokémon
            $heading = "Add Pokémon Success";

            $help_text = "";

            $params = [$pokemonID];

            $sql_condition = "
                WHERE p.PokemonID = ?
            ";

            include("content/results.php");

        }

    }

}


// User not logged in
else {

    $login_error =
        urlencode("Please login to access this page");

    header(
        "Location: index.php?page=admin/login&error=$login_error"
    );

    exit;

}

?>