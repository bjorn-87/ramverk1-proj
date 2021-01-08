<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
// $items = isset($items) ? $items : null;

// var_dump($items);
// var_dump($gravatar);

?><h1>Profil</h1>
<?php if ($items->created === null) : ?>
    <p>Användaren finns ej.</p>
    <?php
    return;
    ?>
<?php elseif ($items->deleted !== null) : ?>
    <p>Användaren är raderad.</p>
    <?php
    return;
endif;
?>
<img src="<?= $gravatar ?>" alt="User">

<table>
    <tr>
        <th>Id</th>
        <th>Användare</th>
        <th>E-post</th>
        <th>Förnamn</th>
        <th>Efternamn</th>
        <th>Medlem sedan</th>
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
