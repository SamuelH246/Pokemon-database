<?php

// Retrieve data
list($find_query, $find_count) = get_query($dbconnect, $sql_condition, $params);

// Set up heading
if ($find_count == 1) {
    $results_heading = $heading;
} else {
    $results_heading = $heading . " (" . $find_count . " results)";
}

if ($find_count > 0) {

    if ($heading != "") {
        ?>

        <h2 class="search-heading">
            <?= htmlspecialchars($results_heading); ?>
        </h2>

        <?php
    }

    // Display help text if it exists
    if ($help_text != "") {
        ?>
        <i class="results-heading">
            <i class="fa-solid fa-circle-info"></i>
            <?= htmlspecialchars($help_text); ?>
        </i>

        <br><br>

        <?php
    } else {
        echo "<br>";
    }

    ?>

    <div class="cards-outer">

        <div class="all-cards">

            <?php

            while ($find_rs = mysqli_fetch_assoc($find_query)) {

                // Main Pokémon information
                $ID = $find_rs['PokemonID'];

                // Pokémon image filenames match the Pokémon ID
                $pokemon_image = "images/pokemon/" . $ID . ".png";

                $pokemon = $find_rs['Pokemon_Name'];
                $pokedex = $find_rs['Pokedex_Number'];

                $generation = $find_rs['Generation_Name'];

                $primary_type = $find_rs['Primary_Type'];
                $secondary_type = $find_rs['Secondary_Type'];

                $evolution = $find_rs['Evolution_Stage_Name'];

                $ability = $find_rs['Ability_Name'];

                $speed = $find_rs['Speed'];

                $description = $find_rs['Description'];

                ?>

                <div class="char-details">

                    <!-- Pokémon Name -->
                    <div class="character-name">
                        <?= htmlspecialchars($pokemon); ?>
                    </div>


                    <!-- Pokémon Image -->
                    <div class="pokemon-image-holder">

                        <img
                            class="pokemon-image"
                            src="<?= $pokemon_image; ?>"
                            alt="<?= htmlspecialchars($pokemon); ?>"
                        >

                    </div>


                    <!-- Generation -->
                    <div class="play-title">

                        <a class="play"
                           href="index.php?page=content/click_search&search_type=generation&search_term=<?= urlencode($generation); ?>">

                            <?= htmlspecialchars($generation); ?>

                        </a>

                    </div>


                    <!-- Pokémon Information -->
                    <div class="description">

                        <p>
                            <strong>Pokédex Number:</strong>
                            #<?= htmlspecialchars($pokedex); ?>
                        </p>


                        <!-- Primary type text link -->
                        <p>
                            <strong>Primary Type:</strong>

                            <a href="index.php?page=content/click_search&search_type=type&search_term=<?= urlencode($primary_type); ?>"
                               class="trait">

                                <?= htmlspecialchars($primary_type); ?>

                            </a>
                        </p>


                        <?php

                        // Only display secondary type if the Pokémon has one
                        if (!empty($secondary_type)) {

                        ?>

                            <!-- Secondary type text link -->
                            <p>
                                <strong>Secondary Type:</strong>

                                <a href="index.php?page=content/click_search&search_type=type&search_term=<?= urlencode($secondary_type); ?>"
                                   class="trait">

                                    <?= htmlspecialchars($secondary_type); ?>

                                </a>
                            </p>

                        <?php

                        } // end secondary type if

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


                    <!-- Type Tags -->
                    <div class="trait-tags">

                        <!--
                        The Pokémon type is converted to lowercase
                        so it matches the CSS class names.
                        Example:
                        Electric -> type-electric
                        Water -> type-water
                        -->
                        <a href="index.php?page=content/click_search&search_type=type&search_term=<?= urlencode($primary_type); ?>"
                           class="trait type-<?= strtolower($primary_type); ?>">

                            <?= htmlspecialchars($primary_type); ?>

                        </a>


                        <?php

                        // Only create a second type tag if the Pokémon
                        // actually has a secondary type
                        if (!empty($secondary_type)) {

                        ?>

                            <a href="index.php?page=content/click_search&search_type=type&search_term=<?= urlencode($secondary_type); ?>"
                               class="trait type-<?= strtolower($secondary_type); ?>">

                                <?= htmlspecialchars($secondary_type); ?>

                            </a>

                        <?php

                        }

                        ?>

                    </div>


                    <?php

                    // If user is logged in, show edit / delete buttons
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

                <?php

            } // end results while

            ?>

        </div>

    </div>

    <?php

} else {

    ?>

    <h2>No Results</h2>

    <div class="no-results-message">

        <div class="center-image">

            <img class="error-image"
                 src="images/no_results.png"
                 alt="No results">

        </div>

        <p>&nbsp;</p>

        <div class="error all">

            <p>
                Sorry! There are no results for your search.
            </p>

            <p>
                Please try another search term.
            </p>

        </div>

    </div>

    <?php

}

?>

<p>&nbsp;</p>