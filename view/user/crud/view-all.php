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

?><h1>Alla användare</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<article class="userPageArticle">
    <?php foreach ($items as $item) : ?>
        <div class="userCard">
            <a href="<?= url("userpage/user/{$item->username}"); ?>">
                <img class="userImg" src="<?= $gravatar->getGravatar($item->email)?>" alt="gravatar">
                <p><?= $item->username ?></p>
                <p><?= $item->email ?></p>
            </a>
        </div>
    <?php endforeach; ?>
</article>
