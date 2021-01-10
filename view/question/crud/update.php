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
$id = isset($id) ? $id : null;

// Create urls for navigation
$urlToView = url("question/questid/{$id}");
$urlToCreateTag = url("tags/create/{$id}");
$urlToDeleteTag = url("tags/delete/{$id}");

// var_dump($form);

?><h1>Update an item</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToCreateTag ?>">Skapa tagg</a>
    <a href="<?= $urlToDeleteTag ?>">Radera tagg</a>
</p>
<p>
    <a href="<?= $urlToView ?>">View all</a>
</p>
