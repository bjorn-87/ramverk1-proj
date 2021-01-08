<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;
$username = isset($username) ? $username : null;

// var_dump($form);

// Create urls for navigation
$urlToView = url("userpage/user/{$username}");



?><h1>Uppdatera konto</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToView ?>">Tillbaka</a>
</p>
