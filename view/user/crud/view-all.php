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
$urlToDelete = url("user/delete");



?><h1>View all items</h1>

<p>
    <a href="<?= $urlToDelete ?>">Delete</a>
</p>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<table>
    <tr>
        <th>Id</th>
        <th>Column1</th>
        <th>Column2</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("user/update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><?= $item->username ?></td>
        <td><?= $item->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
