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


?><h1>Frågor taggade med [<?= htmlentities($title) ?>]</h1>

<?php if (!$items) : ?>
    <p>Det finns inga frågor taggade med <b><?= htmlentities($title) ?></b>.</p>
    <?php
    return;
endif;
?>
<article>
    <?php foreach ($items as $item) : ?>
        <div class="" style="border: 1px solid black; padding: 0.5em; margin-bottom: 0.5em;">
            <a href="<?= url("question/questid/{$item["id"]}"); ?>"><?= $item["title"] ?></a>
            <?= $item["username"] ?></td>
        </div>
    <?php endforeach; ?>
</article>
