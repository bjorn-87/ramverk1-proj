<?php

namespace Bjos\Comment;

use Bjos\MyActiveRecordModel\MyActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class AnswerComment extends MyActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answercomment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $answerid;
    public $username;
    public $text;
    public $vote;
    public $created;
    public $updated;
    public $deleted;
}
