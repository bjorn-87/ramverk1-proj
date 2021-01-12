<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}

// Create urls for navigation
$urlToCreate = url("user/create");

?><h1>Logga in</h1>

<article <?= classList($classes) ?>>
<?= $content ?>
<p>
    Inget konto? <a href="<?= $urlToCreate ?>">Skapa konto</a>
</p>
</article>
