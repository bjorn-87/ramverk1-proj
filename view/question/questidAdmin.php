<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$id = isset($id) ? $id : null;

$urlToUpdate = url("question/update/{$id}");
$urlToDelete = url("question/delete/{$id}");

?>

<?php if (!$id) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<article>
    <div class="pageButton">
        <a href="<?= $urlToUpdate ?>">Uppdatera</a>
        <a href="<?= $urlToDelete ?>">Radera</a>
    </div>
</article>
