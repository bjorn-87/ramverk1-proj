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
$urlToCreate = url("tags/create");
$urlToDelete = url("tags/delete");

// var_dump($items);


?><h1>Frågor taggade med [<?= strip($title) ?>]</h1>
<form class="htmlform" action="<?= url("tags/tag") ?>" method="get">
    <input type="text" name="name" value="" placeholder="Tryck Enter för att söka">
</form>

<?php if (!$items) : ?>
    <p>Det finns inga frågor taggade med <b><?= strip($title) ?></b>.</p>
    <a href="<?= url("tags") ?>">Tillbaka</a>
    <?php
    return;
endif;
?>


<article>
    <?php foreach ($items as $item) : ?>
        <div class="tagBox">
            <a href="<?= url("question/questid/{$item["id"]}"); ?>"><?= $item["title"] ?></a>
            <a href="<?= url("userpage/user/{$item["username"]}"); ?>">Frågat av: <?= strip($item["username"]) ?></a>
        </div>
    <?php endforeach; ?>
    <a href="<?= url("tags") ?>">Tillbaka</a>
</article>
