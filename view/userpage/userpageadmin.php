<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
// $items = isset($items) ? $items : null;

// var_dump($items);
// var_dump($gravatar);
?><a class="askQuestion" href="<?= url("user/update/"); ?>">Uppdatera</a>
<a class="delete" href="<?= url("user/delete/"); ?>">Radera användare</a>
