<?php

namespace Bjos\Comment\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\Comment\QuestionComment;
use Bjos\Comment\AnswerComment;

/**
 * Form to create an item.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id, $type, $questId)
    {
        parent::__construct($di);
        $this->questId = $questId;
        $session = $di->get("session", null);
        $user = $session->get("user", null);
        $username = isset($user) ? $user["username"] : null;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the item",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $id,
                ],

                "type" => [
                    "type" => "hidden",
                    "value" => $type,
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
                    "value" => "Create item",
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
        $commentID  = $this->form->value("id");
        $type  = $this->form->value("type");
        if ($type === "question") {
            $comment = new QuestionComment();
            $comment->setDb($this->di->get("dbqb"));
            $comment->commentquestionid = $commentID;
        } elseif ($type === "answer") {
            $comment = new AnswerComment();
            $comment->setDb($this->di->get("dbqb"));
            $comment->answerid = $commentID;
        }

        $comment->username  = $this->form->value("username");
        $comment->text = $this->form->value("text");
        $comment->vote = 0;
        $comment->created = date('Y-m-d H:i:s');

        // var_dump($comment);
        $comment->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question/questid/{$this->questId}")->send();
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
