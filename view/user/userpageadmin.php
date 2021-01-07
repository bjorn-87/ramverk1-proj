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
        <th>username</th>
        <th>Email</th>
        <th>Firstname</th>
        <th>Surname</th>
        <th>Member since</th>
    </tr>
    <tr>
        <td>
            <?= $items->id ?>
        </td>
        <td><?= $items->username ?></td>
        <td><?= $items->email ?></td>
        <td><?= $items->firstname ?></td>
        <td><?= $items->surname ?></td>
        <td><?= $items->created ?></td>
    </tr>
</table>

<a href="<?= url("user/update/"); ?>">Uppdatera</a>
