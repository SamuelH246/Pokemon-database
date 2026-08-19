<div class="common logo-banner">
    <a href="index.php">
        <img class="logo-image" src="images/logo.png" alt="Pokemon logo" height="75">
    </a>

    <h1>Pokémon Database</h1>
</div>


<nav>

    <a href="index.php?page=content/random"
       class="nav-button"
       title="Displays five random Pokémon">
        <i class="fa-solid fa-shuffle"></i>
    </a>



    <div class="nav-combo">

        <div class="hamburger">
            <i class="fa-solid fa-search" onclick="changeIcon(this)"></i>
        </div>


        <div class="nav-items">

            <?php

            $quick_searches = [

                'quick_search'     => 'Quick',
                'play_search'      => 'Generation',
                'character_search' => 'Pokémon',
                'death_search'     => 'Type'

            ];

            foreach ($quick_searches as $name => $placeholder) :
            ?>

                <form class="key-search"
                      method="post"
                      action="index.php?page=content/quick_search"
                      enctype="multipart/form-data">

                    <input class="search quicksearch"
                           type="text"
                           name="quick_search_term"
                           value=""
                           required
                           placeholder="<?= $placeholder; ?>">

                    <button type="submit"
                            class="submit"
                            name="<?= $name; ?>">

                        <i class="fa-solid fa-magnifying-glass fa-flip-horizontal"></i>

                    </button>

                </form>

            <?php endforeach; ?>

        </div>

    </div>

</nav>


<div class="log-in-out">

    <?php

    if (isset($_SESSION['admin'])) {
    ?>

        <a class="nav-button"
           href="index.php?page=admin/add_entry"
           title="Add Pokémon">

            <i class="fa-solid fa-plus"></i>

        </a>

        &nbsp; &nbsp;

        <a class="nav-button"
           href="index.php?page=admin/logout"
           title="Logout">

            <i class="fa-solid fa-right-to-bracket fa-flip-horizontal"></i>

        </a>

    <?php

    } else {

    ?>

        <a class="nav-button"
           href="index.php?page=admin/login"
           title="Login">

            <i class="fa-solid fa-right-to-bracket"></i>

        </a>

    <?php
    }

    ?>

</div>