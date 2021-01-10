<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
// $urlToCreate = url("question/create");
// $urlToDelete = url("question/delete");
// var_dump($items);

?><h1>En Admin fråga</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<article>
    <div class="pageButton">Antal per sida:
    </div>
</article>
