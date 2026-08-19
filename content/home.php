<?php

// Retrieve the three Generation I starter Pokémon
$params = [1, 4, 7];

$sql_condition = "
    WHERE p.PokemonID IN (?, ?, ?)
    ORDER BY p.PokemonID ASC
";

list($find_query, $find_count) = get_query(
    $dbconnect,
    $sql_condition,
    $params
);

?>

<h2>Welcome</h2>

<p>
    Use the random and search tools above to explore Pokémon from Generations I, II and III.
    Here are the original starter Pokémon to get you started.
</p>

<p>
    Hover over the images below to learn more about each Pokémon.
</p>

<p>&nbsp;</p>


<div class='home-starters'>

<?php

while ($find_rs = mysqli_fetch_assoc($find_query)) {

    // Main Pokémon information
    $ID = $find_rs['PokemonID'];

    $pokemon = $find_rs['Pokemon_Name'];
    $pokedex = $find_rs['Pokedex_Number'];

    $generation = $find_rs['Generation_Name'];

    $primary_type = $find_rs['Primary_Type'];
    $secondary_type = $find_rs['Secondary_Type'];

    $evolution = $find_rs['Evolution_Stage_Name'];

    $ability = $find_rs['Ability_Name'];

    $speed = $find_rs['Speed'];

    $description = $find_rs['Description'];


    // Pokémon image filenames match their Pokémon ID
    $avatar = "images/pokemon/" . $ID . ".png";


    // URL helpers for clickable search links
    $click_type = "index.php?page=content/click_search&search_type=";
    $click_term = "&search_term=";

?>

<div class="container">

    <!-- Starter Pokémon image -->
    <img
        src="<?= $avatar; ?>"
        alt="<?= htmlspecialchars($pokemon); ?>"
        class="featured-image"
    >


    <!-- Card shown when image is hovered over -->
    <div class="overlay">

        <div class="char-details">

            <!-- Pokémon name -->
            <div class="character-name">
                <?= htmlspecialchars($pokemon); ?>
            </div>


            <!-- Generation -->
            <div class="play-title">

                <a class="play"
                   href="<?= $click_type; ?>generation<?= $click_term . urlencode($generation); ?>">

                    <?= htmlspecialchars($generation); ?>

                </a>

            </div>


            <!-- Pokémon information -->
            <div class="description">

                <p>
                    <strong>Pokédex Number:</strong>
                    #<?= htmlspecialchars($pokedex); ?>
                </p>


                <p>
                    <strong>Primary Type:</strong>

                    <a href="<?= $click_type; ?>type<?= $click_term . urlencode($primary_type); ?>"
                       class="trait">

                        <?= htmlspecialchars($primary_type); ?>

                    </a>
                </p>


                <?php

                // Only show secondary type if Pokémon has one
                if (!empty($secondary_type)) {

                ?>

                    <p>
                        <strong>Secondary Type:</strong>

                        <a href="<?= $click_type; ?>type<?= $click_term . urlencode($secondary_type); ?>"
                           class="trait">

                            <?= htmlspecialchars($secondary_type); ?>

                        </a>
                    </p>

                <?php

                }

                ?>


                <p>
                    <strong>Evolution Stage:</strong>
                    <?= htmlspecialchars($evolution); ?>
                </p>


                <p>
                    <strong>Ability:</strong>
                    <?= htmlspecialchars($ability); ?>
                </p>


                <p>
                    <strong>Speed:</strong>
                    <?= htmlspecialchars($speed); ?>
                </p>


                <p>
                    <?= htmlspecialchars($description); ?>
                </p>

            </div>


            <!-- Pokémon type tags -->
            <div class="trait-tags">

                <a href="<?= $click_type; ?>type<?= $click_term . urlencode($primary_type); ?>"
                   class="trait type-<?= strtolower($primary_type); ?>">

                    <?= htmlspecialchars($primary_type); ?>

                </a>


                <?php

                if (!empty($secondary_type)) {

                ?>

                    <a href="<?= $click_type; ?>type<?= $click_term . urlencode($secondary_type); ?>"
                       class="trait type-<?= strtolower($secondary_type); ?>">

                        <?= htmlspecialchars($secondary_type); ?>

                    </a>

                <?php

                }

                ?>

            </div>


            <?php

            // If admin is logged in, show edit and delete buttons
            if (isset($_SESSION['admin'])) {

            ?>

                <div class="tools">

                    <a class="nav-button"
                       href="index.php?page=admin/edit&ID=<?= $ID; ?>">

                        <i class="fa-solid fa-pen-nib"></i>

                    </a>

                    &nbsp; &nbsp;

                    <a class="nav-button"
                       href="index.php?page=admin/delete_confirm&ID=<?= $ID; ?>">

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </div>

            <?php

            }

            ?>

        </div>

    </div>

</div>

<?php

} // end results while

?>

</div>