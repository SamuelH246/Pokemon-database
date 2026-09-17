<?php

if(isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];

    // Retrieve Pokémon details
    $get_entry_sql = "WHERE p.PokemonID LIKE ?";
    $params = [$ID];

    $get_entry_query = get_query($dbconnect, $get_entry_sql, $params)[0];
    $get_entry_rs = mysqli_fetch_assoc($get_entry_query);

    // Existing values
    $pokemon_name = $get_entry_rs['Pokemon_Name'];
    $pokedex_number = $get_entry_rs['Pokedex_Number'];
    $description = $get_entry_rs['Description'];
    $speed = $get_entry_rs['Speed'];

    $GenerationID = $get_entry_rs['GenerationID'];
    $Generation = $get_entry_rs['Generation_Name'];

    $PrimaryTypeID = $get_entry_rs['PrimaryTypeID'];
    $PrimaryType = $get_entry_rs['Primary_Type'];

    $SecondaryTypeID = $get_entry_rs['SecondaryTypeID'] ?? "";
    $SecondaryType = $get_entry_rs['Secondary_Type'] ?? "";

    $EvolutionStageID = $get_entry_rs['EvolutionStageID'];
    $EvolutionStage = $get_entry_rs['Evolution_Stage_Name'];

    $AbilityID = $get_entry_rs['AbilityID'];
    $Ability = $get_entry_rs['Ability_Name'];


    // dropdown details:
    // name | table | ID field | value field | current display | current ID
    $dropdown_details = [

        ['generation', 'Generation', 'GenerationID', 'Generation_Name', $Generation, $GenerationID],

        ['primary_type', 'Type', 'TypeID', 'Type_Name', $PrimaryType, $PrimaryTypeID],

        ['secondary_type', 'Type', 'TypeID', 'Type_Name', $SecondaryType, $SecondaryTypeID],

        ['evolution_stage', 'Evolution_Stage', 'EvolutionStageID', 'Evolution_Stage_Name', $EvolutionStage, $EvolutionStageID],

        ['ability', 'Ability', 'AbilityID', 'Ability_Name', $Ability, $AbilityID],

    ];

?>

<div class="big-form">

    <h2>Edit Pokémon</h2>

    <form action="index.php?page=admin/edit_entry&ID=<?= $ID; ?>" method="post">

        <p>
            <input
                name="pokemon_name"
                value="<?= htmlspecialchars($pokemon_name); ?>"
                required
            >
        </p>

        <p>
            <input
                name="pokedex_number"
                type="number"
                value="<?= htmlspecialchars($pokedex_number); ?>"
                required
            >
        </p>

        <?php

        foreach($dropdown_details as $drop) {

            list(
                $name,
                $table,
                $id_field,
                $label_field,
                $placeholder,
                $value
            ) = $drop;

        ?>

        <select
            class="marg-bottom"
            name="<?= htmlspecialchars($name); ?>"
            <?= $name != "secondary_type" ? "required" : ""; ?>
        >

            <?php if ($name == "secondary_type" && $value === ""): ?>

                <option value="" selected>No Secondary Type</option>

            <?php else: ?>

                <option value="<?= htmlspecialchars((string)$value); ?>" selected>
                    <?= htmlspecialchars((string)$placeholder); ?>
                </option>

                <?php if ($name == "secondary_type"): ?>
                    <option value="">No Secondary Type</option>
                <?php endif; ?>

            <?php endif; ?>

            <?php
                get_options(
                    $dbconnect,
                    $table,
                    $id_field,
                    $label_field
                );
            ?>

        </select>

        <?php
        }
        ?>

        <p>
            <input
                name="speed"
                type="number"
                value="<?= htmlspecialchars($speed); ?>"
                required
            >
        </p>

        <p>
            <textarea
                name="description"
                required
            ><?= htmlspecialchars($description); ?></textarea>
        </p>

        <button
            class="form-submit pad-10"
            type="submit"
            name="submit"
        >
            Save Changes
        </button>

    </form>

</div>

<?php

}

else {

    $login_error = urlencode('Please login to access this page');

    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}

?>