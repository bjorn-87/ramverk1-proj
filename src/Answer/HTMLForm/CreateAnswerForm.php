<?php

namespace Bjos\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\Answer\Answer;
use Bjos\Question\Question;

/**
 * Form to create an item.
 */
 /**
  * Form to create an item.
  */
class CreateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $session = $di->get("session", null);
        $this->id = $id;
        $user = $session->get("user", null);
        $username = isset($user) ? $user["username"] : null;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Svara",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $id,
                ],

                "username" => [
                    "type" => "hidden",
                    "value" => $username,
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Svara",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    /**
     * Finds question and retiurns id-
     *
     * @return Object Question.
     */
    public function findQuestion()
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $oneQuestion = $question->find("id", $this->id);
        return $oneQuestion;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $answer->questionid  = $this->form->value("id");
        $answer->username  = $this->form->value("username");
        $answer->text = $this->form->value("text");
        $answer->vote = 0;
        $answer->created = date('Y-m-d H:i:s');

        $question = $this->findQuestion();
        $question->setDb($this->di->get("dbqb"));
        $question->answers += 1;
        $question->updated = date('Y-m-d H:i:s');
        $question->save();

        $answer->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question/questid/{$this->id}")->send();
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
