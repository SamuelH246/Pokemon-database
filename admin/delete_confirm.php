<?php

if(isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];

    $heading = "";
    $help_text = "";

    $params = [$ID];

    $sql_condition = "WHERE p.PokemonID LIKE ?";

?>

<h2>Delete Pokémon</h2>

<p>Are you sure you want to delete this Pokémon?</p>

<div class="single-holder">

<?php

include("content/results.php");

?>

<div class="error">

    <p>Are you sure you want to delete this Pokémon?</p>

    <div class="trait-tags delete-tags">

        <a
            class="trait pad-10"
            href="index.php?page=admin/delete_entry&ID=<?= $ID; ?>"
        >
            Yes, Delete it!
        </a>

        <a
            class="trait pad-10"
            href="javascript:history.back()"
        >
            No, take me back
        </a>

    </div>

</div>

</div>

<?php

}

else {

    $login_error = urlencode('Please login to access this page');

    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}

?>