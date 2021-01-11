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

// var_dump($items);

?><h1>Alla taggar</h1>

<?php if (!$items) : ?>
    <p>Finns inga taggar.</p>
    <?php
    return;
endif;
?>

<article>
    <?php foreach ($items as $item) : ?>
        <div class="" style="border: 1px solid black; padding: 0.5em; margin-bottom: 0.5em;">
            <a href="<?= url("tags/tag?name={$item->text}"); ?>"><?= $item->text ?></a>
        </div>
    <?php endforeach; ?>
</article>
