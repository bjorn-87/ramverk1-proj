<?php

namespace Bjos\Question;

use Bjos\MyActiveRecordModel\MyActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends MyActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $username;
    public $title;
    public $text;
    public $vote;
    public $answers;
    public $created;
    public $updated;
    public $deleted;



    /**
     *
     *
     *
     */
    public function markdownParse($di, $object, $filter)
    {
        $textfilter = $di->get("textfilter");
        foreach ($object as $value) {
            $value->text = $textfilter->parse($value->text, $filter)->text;
        }
        return $object;
    }
}
