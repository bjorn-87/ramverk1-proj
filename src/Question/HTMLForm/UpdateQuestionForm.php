<?php

namespace Bjos\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\Question\Question;
use Bjos\Tags\Tags;

/**
 * Form to create an item.
 */
class UpdateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $quest = $this->getItemDetails($di, $id);
        $tags = $this->getTags($di, $id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the item",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $quest->id,
                ],

                "username" => [
                    "type" => "hidden",
                    "value" => $quest->username,
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $quest->title,
                ],

                "text" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $quest->text,
                ],

                "tags" => [
                    "type" => "text",
                    "value" => $tags,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Update item",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Question
     */
    public function getItemDetails($di, $id) : object
    {
        $question = new Question();
        $question->setDb($di->get("dbqb"));
        $question->find("id", $id);
        $textfilter = $di->get("textfilter");

        $parsedTitle = $textfilter->parse($question->title, ["purify"]);
        $parsedText = $textfilter->parse($question->text, ["purify"]);
        $question->title = $parsedTitle->text;
        $question->text = $parsedText->text;

        return $question;
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return string string with tags separated by space
     */
    public function getTags($di, $id, $type = "string")
    {
        $tags = new Tags();
        $tags->setDb($di->get("dbqb"));
        $foundTags = $tags->findAllWhere("tagquestionid = ? AND DELETED IS NULL", [$id]);

        if ($type === "string") {
            $res = "";
            foreach ($foundTags as $value) {
                $res .= $value->text . " ";
            }
            return rtrim($res);
        }
        return $foundTags;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $newTags = $this->form->value("tags");
        $newTagsArray  = explode(" ", $newTags);
        $questionId = $this->form->value("id");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $question->id  = $questionId;
        $question->username  = $this->form->value("username");
        $question->title  = $this->form->value("title");
        $question->text = $this->form->value("text");
        $question->updated = date('Y-m-d H:i:s');
        $question->save();

        $oldTags = $this->getTags($this->di, $questionId, "array");

        $countOld = count($oldTags);
        $countNew = count($newTagsArray);

        if (isset($oldTags)) {
            if ($countNew === $countOld) {
                for ($i=0; $i < $countOld; $i++) {
                    $tag = new Tags();
                    $tag->setDb($this->di->get("dbqb"));
                    $tag->id = $oldTags[$i]->id;
                    $tag->tagquestionid = $questionId;
                    $tag->text = $newTagsArray[$i];
                    $tag->updated = date('Y-m-d H:i:s');
                    $tag->save();
                }
            }
        }
        return true;
    }

    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("question")->send();
    // }
    //
    //
    //
    //     // /**
    //     //  * Callback what to do if the form was unsuccessfully submitted, this
    //     //  * happen when the submit callback method returns false or if validation
    //     //  * fails. This method can/should be implemented by the subclass for a
    //     //  * different behaviour.
    //     //  */
    //     // public function callbackFail()
    //     // {
    //     //     $this->di->get("response")->redirectSelf()->send();
    //     // }
}
