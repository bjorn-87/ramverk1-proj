<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!$users && !$tags) {
    return;
}
?>




<div class="homepageIndex">
    <div class="block">
        <div class="product-list-item">
            <h4>Top Användare: </h4>
            <?php foreach ($users as $user) : ?>
                <p>Frågor: <?= $user->amount ?>
                <a href="<?= url("userpage/user/{$user->username}") ?>"><?= esc($user->username) ?></a></p>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="block">
        <h4>Top Taggar: </h4>
        <?php foreach ($tags as $tag) : ?>
            <p>Antal frågor: <?= $tag->amount ?>
            <a href="<?= url("tags/tag?name={$tag->text}") ?>">#<?= esc($tag->text) ?></a></p>
        <?php endforeach; ?>
    </div>
</div>
