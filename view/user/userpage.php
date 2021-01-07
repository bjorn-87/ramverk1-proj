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

// var_dump($items);
// var_dump($gravatar);

?><h1>Aktivitetssida</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>
<img src="<?= $gravatar ?>" alt="User">
<table>
    <tr>
        <th>Id</th>
        <th>Column1</th>
        <th>Column2</th>
    </tr>
    <tr>
        <td>
            <?= $items->id ?>
        </td>
        <td><?= $items->username ?></td>
        <td><?= $items->email ?></td>
    </tr>
</table>
