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

<form class="htmlform" action="<?= url("tags/tag") ?>" method="get">
    <input type="text" name="name" value="" placeholder="Tryck Enter för att söka">
</form>

<article>
    <?php foreach ($items as $item) : ?>
        <div class="tagLink">
            <a href="<?= url("tags/tag?name={$item->text}"); ?>"><?= $item->text ?></a>
        </div>
    <?php endforeach; ?>
</article>
