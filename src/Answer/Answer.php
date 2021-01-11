<?php

namespace Bjos\Answer;

use Bjos\MyActiveRecordModel\MyActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends MyActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answer";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $questionid;
    public $username;
    public $text;
    public $accepted;
    public $vote;
    public $created;
    public $updated;
    public $deleted;
}
