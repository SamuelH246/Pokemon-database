<?php

if(isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];

    $stmt_delete = $dbconnect->prepare(
        "DELETE FROM pokemon WHERE PokemonID = ?"
    );

    $stmt_delete->bind_param("i", $ID);

    $stmt_delete->execute();

    $stmt_delete->close();

?>

<h2>Delete Success</h2>

<p>The Pokémon has been deleted.</p>

<?php

}

else {

    $login_error = urlencode('Please login to access this page');

    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}

?>