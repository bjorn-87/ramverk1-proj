<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());
$users = isset($users) ? $users : null;
$tags = isset($tags) ? $tags : null;
$questions = isset($questions) ? $questions : null;
?>

<?php if (!$users && !$tags && !$questions) : ?>
    <h1>404</h1>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>
<main>

    <h1>Välkommen till ConsoleOverflow</h1>
    Sidan där du kan få reda på allt om spelkonsoler.

    <h2>Senaste Frågorna: </h2>
    <?php foreach ($questions as $questions) : ?>
        <p><a href="<?= url("question/questid/{$questions->id}") ?>"><?= strip($questions->title) ?></a></p>
    <?php endforeach; ?>


</main>
