<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
// var_dump(get_defined_functions());
// echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToLogin = url("user/login");



?><h1>Skapa Konto</h1>

<?= $form ?>

<p>
    Har du redan ett konto? <a href="<?= $urlToLogin ?>"> Logga in</a>
</p>
