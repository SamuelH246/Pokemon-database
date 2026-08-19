<?php

function get_query($dbconnect, $sql_condition, $params = [])
{
    // p   ==> pokemon table
    // gen ==> generation table
    // pt  ==> primary type
    // st  ==> secondary type
    // evo ==> evolution stage
    // ab  ==> ability

    $find_sql = "
        SELECT
            p.*,
            gen.Generation_Name,
            pt.Type_Name AS Primary_Type,
            st.Type_Name AS Secondary_Type,
            evo.Evolution_Stage_Name,
            ab.Ability_Name

        FROM pokemon p

        JOIN Generation gen
            ON gen.GenerationID = p.GenerationID

        JOIN `Type` pt
            ON pt.TypeID = p.PrimaryTypeID

        LEFT JOIN `Type` st
            ON st.TypeID = p.SecondaryTypeID

        JOIN Evolution_Stage evo
            ON evo.EvolutionStageID = p.EvolutionStageID

        JOIN Ability ab
            ON ab.AbilityID = p.AbilityID

        $sql_condition
    ";

    // Prepared statement
    $stmnt = $dbconnect->prepare($find_sql);

    if (!empty($params)) {

        // Treat all parameters as strings
        $types = str_repeat('s', count($params));

        $bind_values = [];

        foreach ($params as $key => $value) {
            $bind_values[$key] = &$params[$key];
        }

        array_unshift($bind_values, $types);

        call_user_func_array(
            [$stmnt, 'bind_param'],
            $bind_values
        );
    }

    $stmnt->execute();

    $find_query = $stmnt->get_result();
    $find_count = $find_query->num_rows;

    $stmnt->close();

    return [$find_query, $find_count];
}


// Trim white space from search terms
function to_clean($data)
{
    $data = trim($data);
    return $data;
}


// Generate dropdown menu based on a database table
function get_options($dbconnect, $table, $idField, $valueField)
{
    $dropdownSql = "
        SELECT *
        FROM `$table`
        ORDER BY `$valueField` ASC
    ";

    $dropdownQuery = mysqli_query($dbconnect, $dropdownSql);

    while ($dropdownRs = mysqli_fetch_assoc($dropdownQuery)) {
        ?>

        <option value="<?= $dropdownRs[$idField]; ?>">
            <?= htmlspecialchars($dropdownRs[$valueField]); ?>
        </option>

        <?php
    }
}


// Generate autocomplete list
function autocomplete_list($dbconnect, $item_sql, $entity)
{
    $all_items_query = mysqli_query($dbconnect, $item_sql);

    $items = [];

    while ($row = mysqli_fetch_array($all_items_query)) {
        $item = $row[$entity];
        $items[] = $item;
    }

    $all_items = json_encode($items);

    return $all_items;
}


// Find Pokémon ID from Pokémon name
function get_search_ID($dbconnect, $search_term)
{
    $stmnt_findID = $dbconnect->prepare(
        "SELECT PokemonID
         FROM pokemon
         WHERE Pokemon_Name LIKE ?"
    );

    $stmnt_findID->bind_param("s", $search_term);

    $stmnt_findID->execute();

    $result = $stmnt_findID->get_result();

    $find_rs = $result->fetch_assoc();

    $find_count = $result->num_rows;

    if ($find_count == 1) {

        $pokemonID = $find_rs['PokemonID'];

        $stmnt_findID->close();

        return $pokemonID;

    } else {

        $stmnt_findID->close();

        return "no results";
    }
}

?>