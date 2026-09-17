<?php

// Check user is logged in
if (isset($_SESSION['admin'])) {

    // Dropdown setup:
    // form name | table | ID field | display field | placeholder
    $dropdown_details = [

        [
            'generation',
            'Generation',
            'GenerationID',
            'Generation_Name',
            'Generation...'
        ],

        [
            'primary_type',
            'Type',
            'TypeID',
            'Type_Name',
            'Primary Type...'
        ],

        [
            'secondary_type',
            'Type',
            'TypeID',
            'Type_Name',
            'Secondary Type...'
        ],

        [
            'evolution_stage',
            'Evolution_Stage',
            'EvolutionStageID',
            'Evolution_Stage_Name',
            'Evolution Stage...'
        ],

        [
            'ability',
            'Ability',
            'AbilityID',
            'Ability_Name',
            'Ability...'
        ]

    ];

?>

<div class="big-form">

    <h2>Add Pokémon</h2>

    <form action="index.php?page=admin/insert_entry" method="post">

        <p>
            <input
                name="pokemon_name"
                placeholder="Pokémon Name"
                required
            />
        </p>


        <p>
            <input
                name="pokedex_number"
                type="number"
                placeholder="Pokédex Number"
                required
            />
        </p>


        <?php

        foreach ($dropdown_details as $drop) {

            list(
                $name,
                $table,
                $id_field,
                $label_field,
                $placeholder
            ) = $drop;

        ?>

            <select
                class="marg-bottom"
                name="<?= $name; ?>"
                id="<?= $name; ?>"
                <?= $name != "secondary_type" ? "required" : ""; ?>
            >

                <option value="" selected>
                    <?= htmlspecialchars($placeholder); ?>
                </option>

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
                placeholder="Speed"
                required
            />
        </p>


        <p>
            <textarea
                name="description"
                placeholder="Pokémon Description"
                required
            ></textarea>
        </p>


        <button
            class="form-submit pad-10"
            type="submit"
            name="submit"
        >
            Add Pokémon
        </button>

    </form>

</div>


<!-- Prevent Primary Type and Secondary Type being the same -->
<script>

    const primaryType = document.getElementById("primary_type");
    const secondaryType = document.getElementById("secondary_type");

    primaryType.addEventListener("change", function () {

        // Go through every Secondary Type option
        for (let option of secondaryType.options) {

            // Make all options available again first
            option.disabled = false;

            // Disable the type currently selected as Primary Type
            if (
                option.value === primaryType.value &&
                option.value !== ""
            ) {
                option.disabled = true;
            }
        }

        // If the same type was already selected as Secondary Type,
        // reset the Secondary Type dropdown
        if (secondaryType.value === primaryType.value) {
            secondaryType.value = "";
        }

    });

</script>


<?php

}

// User isn't logged in
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