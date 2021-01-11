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
$urlToCreate = url("question/create");
$urlToDelete = url("question/delete");
// var_dump($items);
$defaultRoute = "?";

?><h1>Alla frågor</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>
<a href="<?= $urlToCreate ?>">Ställ fråga</a>

<article>
    <div class="pageButton">Antal per sida:
        <a href="<?= mergeQueryString(["limit" => 2], $defaultRoute) ?>">2</a>
        <a href="<?= mergeQueryString(["limit" => 4], $defaultRoute) ?>">4</a>
        <a href="<?= mergeQueryString(["limit" => 8], $defaultRoute) ?>">8</a>
    </div>
    <?php foreach ($items as $item) : ?>
        <div class="" style="border: 1px solid black; margin-bottom: 0.5em; padding: 0.5em;">
            <div class="">
                Röster: <?= $item["vote"]?>
                Svar: <?= $item["answers"]?>
                <p>Frågad av: <a href="<?= url("userpage/user/{$item["username"]->text}"); ?>"><?= $item["username"]->text ?></a></p>
            </div>
            <h2><a href="<?= url("question/questid/{$item["id"]}"); ?>"><?= $item["title"]->text ?></a></h2>
            <?= substr($item["text"]->text, 0, 50) ?>...<br><a href="<?= url("question/questid/{$item["id"]}"); ?>">Läs mer</a><br>

            <?php if ($item["tags"]) : ?>
                <?php foreach ($item["tags"] as $value) : ?>
                    <a href="<?= url("tags/tag?name={$value->text}"); ?>">#<?= $value->text ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    <?php endforeach; ?>
    <div class="pageButton">
    Sidor:
    <?php for ($i = 1; $i <= $max; $i++) : ?>
        <a href="<?= mergeQueryString(["page" => $i], $defaultRoute) ?>"><?= $i ?></a>
    <?php endfor; ?>
    </div>
</article>
