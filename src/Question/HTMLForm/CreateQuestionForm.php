<?php

namespace Bjos\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\Question\Question;
use Bjos\Tags\Tags;

/**
 * Form to create an item.
 */
class CreateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $username)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Ställ fråga",
            ],
            [
                "username" => [
                    "type" => "hidden",
                    "value" => $username,
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type" => "text",
                    "placeholder" => "Skriv in taggens/taggarnas namn separerade med mellanslag"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka",
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
        $tags  = explode(" ", $this->form->value("tags"));
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title  = $this->form->value("title");
        $question->username  = $this->form->value("username");
        $question->text = $this->form->value("text");
        $question->vote = 0;
        $question->answers = 0;
        $question->created = date('Y-m-d H:i:s');

        $question->save();

        $questionId = $question->findMax();
        foreach ($tags as $value) {
            if ($value) {
                $tag = new Tags();
                $tag->setDb($this->di->get("dbqb"));
                $tag->tagquestionid = $questionId->id;
                $tag->text = $value;
                $tag->save();
                // var_dump($tag);
            }
        }
            // var_dump($questionId);

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
