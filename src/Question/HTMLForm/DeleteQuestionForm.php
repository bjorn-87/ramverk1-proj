<?php

namespace Bjos\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\Question\Question;
use Bjos\Tags\Tags;

/**
 * Form to delete an item.
 */
class DeleteQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Radera fråga",
            ],
            [
                "id" => [
                    "type"  => "number",
                    "readonly" => true,
                    "value" => $id,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Radera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $id = $this->form->value("id");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);
        $question->deleted = date('Y-m-d H:i:s');
        $question->save();

        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));
        $foundTag = $tags->findAllWhere("tagquestionid = ?", $id);
        if ($foundTag) {
            foreach ($foundTag as $tag) {
                $tag->setDb($this->di->get("dbqb"));
                $tag->deleted = date('Y-m-d H:i:s');
                $tag->save();
                // var_dump($tag);
            }
        }


        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question")->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
