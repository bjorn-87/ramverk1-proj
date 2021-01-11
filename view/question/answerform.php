<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$answerForm = isset($answerForm) ? $answerForm : null;

?>

<?php if (!$answerForm) : ?>
    <p>404</p>
    <?php
    return;
endif;
?>

<?= $answerForm ?>
