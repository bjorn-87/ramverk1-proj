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

?><h1>View all items</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<article class="" style="display: flex; padding: 0.5em;">
    <?php foreach ($items as $item) : ?>
        <a href="<?= url("userpage/user/{$item->username}"); ?>">
        <div class="" style="border: 1px solid black; display: flex; width: 200px; padding: 0.5em; margin: 0.5em; overflow-wrap: break-word; ">
            <img src="<?= $gravatar->getGravatar($item->email)?>" alt="gravatar" style="padding: 0.5em;">
            <p>
                <a href="<?= url("userpage/user/{$item->username}"); ?>"><?= $item->username ?></a><br>
            </p>
        </div>
        </a>
    <?php endforeach; ?>
</article>
