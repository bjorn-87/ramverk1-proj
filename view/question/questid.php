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
$answers = isset($answers) ? $answers : null;
$qComments = isset($qComments) ? $qComments : null;
$aComments = isset($aComments) ? $aComments : null;
$deleted = isset($items["deleted"]) ? true : false;

// Create urls for navigation

// $urlToUSerPage = ;
// $urlToDelete = url("question/delete");
// var_dump($items);
?>

<?php if (!$items) : ?>
    <h1>404</h1>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?><h1><?= $items["title"] ?></h1>

<article class="" style="padding: 0.5em;">

    <?php if ($deleted) : ?>
        <h1>Raderad: <?= $items["deleted"] ?></h1>
    <?php endif; ?>

    <div>
        <p>Fråga nummer: <?= esc($items["id"]) ?>
        Frågad av: <a href="<?= url("userpage/user/{$items["username"]}"); ?>"><?= esc($items["username"]) ?></a></p>
        <p><?= $items["text"] ?></p>
        <p>Svar: <?= esc($items["answers"]) ?></p>
        <p>Skapad: <?= esc($items["created"]) ?>
        <?=$items["updated"] ? "| Uppdaterad: " . esc($items["updated"]) : null ?></p>
        <?php foreach ($tags as $value) : ?>
            <a href="<?= url("tags/tag?name={$value->text}"); ?>">#<?= esc($value->text) ?></a>
        <?php endforeach; ?>
        <?php if ($loggedIn && !$deleted) : ?>
            <a href="<?= url("comment/create?questid={$questId}&id={$items["id"]}&type=question") ?>">Kommentera</a>
        <?php endif; ?>
    </div>


    <div class="">
        <h5>Kommmentarer:</h5>
        <?php foreach ($qComments as $value) : ?>
            <div class="" style="border-top: 1px solid black; padding: 0.5em;">
            <?= $value->text ?>
            <a href="<?= url("userpage/user/{$value->username}") ?>"><?= $value->username?></a>
            <?= $value->created ?><br>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="pageButton">
        <?php foreach ($answers as $answer) : ?>
            <div class="" style="border: 1px solid black; padding: 0.5em;">
            <h4>Svar:</h4>
            <?= $answer->text ?>

            <a href="<?= url("userpage/user/{$answer->username}") ?>"><?= $answer->username ?></a>
            <?= $answer->created ?><br><br>
            <?php if ($loggedIn && !$deleted) : ?>
                <a href="<?= url("comment/create?questid={$questId}&id={$answer->id}&type=answer") ?>">Kommentera</a>
            <?php endif; ?>

                <h5>Kommentarer:</h5>
                <?php foreach ($answer->aComment as $value) : ?>
                    <div class="" style="border-top: 1px solid black; padding: 0.5em;">

                    <?= $value->text ?>
                    <a href="<?= url("userpage/user/{$value->username}") ?>"><?= $value->username?></a>
                    <?= $value->created ?><br>
                </div>
                <?php endforeach; ?><br>

            </div>
        <?php endforeach; ?>
    </div>
</article>
