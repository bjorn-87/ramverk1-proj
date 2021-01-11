<?php

namespace Bjos\Comment;

use Bjos\MyActiveRecordModel\MyActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class QuestionComment extends MyActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Questioncomment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $commentquestionid;
    public $username;
    public $text;
    public $vote;
    public $created;
    public $updated;
    public $deleted;
}
