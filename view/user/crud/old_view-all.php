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

<table>
    <tr>
        <th>Id</th>
        <th>Column1</th>
        <th>Column2</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td><?= $item->id ?></a></td>
        <td>
            <a href="<?= url("user/userpage/{$item->username}"); ?>"><?= $item->username ?>
        </td>
        <td><?= $item->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
