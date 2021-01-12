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

<img class="userImg" src="<?= $gravatar ?>" alt="User">
<table class="table">
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
</table class="table">

<h4>Frågor:</h4>
<table class="table">
    <tr>
        <th>Titel</th>
        <th>Text</th>
        <th>Antal svar</th>
        <th>Skapad</th>
        <th>Raderad</th>
    </tr>
    <?php foreach ($questions as $quest) : ?>
    <tr>
        <td class=""><a href="<?= url("question/questid/{$quest->id}") ?>"><?= strip($quest->title) ?></a></td>
        <td class="wrapping"><?= substr(strip_tags($quest->text), 0, 30) ?>...</td>
        <td><?= esc($quest->answers) ?></td>
        <td class=""><?= esc($quest->created) ?></td>
        <td class=""><?= esc($quest->deleted) ?></td>
    </tr>
    <?php endforeach; ?>
</table class="table">

<h4>Svar:</h4>
<table class="table">
    <tr>
        <th>Text</th>
        <th>Skapad</th>
    </tr>
    <?php foreach ($answers as $answer) : ?>
    <tr>
        <td class="wrapping"><a href="<?= url("question/questid/{$answer->questionid}") ?>"><?= substr(strip_tags($answer->text), 0, 30) ?>...</a></td>
        <td class="wrapping"><?= esc($answer->created) ?></td>
    </tr>
    <?php endforeach; ?>
</table class="table">

<h4>Kommentarer på svar:</h4>
<table class="table">
    <tr>
        <th>Text</th>
        <th>Skapad</th>
    </tr>
    <?php foreach ($acomments as $acom) : ?>
    <tr>
        <td class="wrapping"><a href="<?= url("question/questid/{$acom->questionid}") ?>"><?= substr(strip_tags($acom->text), 0, 30) ?>...</a></td>
        <td class="wrapping"><?= esc($acom->created) ?></td>
    </tr>
    <?php endforeach; ?>
</table class="table">


<h4>Kommentarer på frågor:</h4>
<table class="table">
    <tr>
        <th>Text</th>
        <th>Skapad</th>
    </tr>
    <?php foreach ($qcomments as $qcom) : ?>
    <tr>
        <td class="wrapping"><a href="<?= url("question/questid/{$qcom->commentquestionid}") ?>"><?= substr(strip_tags($qcom->text), 0, 30) ?>...</a></td>
        <td class="wrapping"><?= esc($qcom->created) ?></td>
    </tr>
    <?php endforeach; ?>
</table class="table">
