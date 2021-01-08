<?php

namespace Bjos\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\Question\HTMLForm\CreateQuestionForm;
// use Bjos\Question\HTMLForm\EditQuestionForm;
use Bjos\Question\HTMLForm\DeleteQuestionForm;
use Bjos\Question\HTMLForm\UpdateQuestionForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $page->add("question/crud/view-all", [
            "items" => $question->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di);
        $form->check();

        $page->add("question/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }

    //
    // /**
    //  * Handler with form to delete an item.
    //  *
    //  * @return object as a response object
    //  */
    // public function deleteAction() : object
    // {
    //     $page = $this->page;
    //     $user = $this->session->get("user", null);
    //     if (!$user) {
    //         $this->di->get("response")->redirect("user/login")->send();
    //     }
    //     $id = isset($user) ? $user["id"] : null;
    //
    //     $tags = $this->tags;
    //     $question = $this->question;
    //
    //
    //     // var_dump($tags);
    //     // var_dump($question);
    //
    //
    //     $tags->setDb($this->di->get("dbqb"));
    //     $question->setDb($this->di->get("dbqb"));
    //
    //
    //     $username = $user["username"];
    //
    //     var_dump($username);
    //     $deleteTags = [];
    //
    //     $userQuestion = $question->findAllWhere("username = ?", $username);
    //
    //     foreach ($userQuestion as $value) {
    //         $qId = $value->id;
    //         $userTags = $tags->findAllWhere("tag_question_id = ?", $qId);
    //         if ($userTags) {
    //             foreach ($userTags as $value) {
    //                 array_push($deleteTags, $value->id);
    //             }
    //         }
    //     }
    //     var_dump($userQuestion);
    //     var_dump($deleteTags);
    //
    //     // $qId =
    //     // $dbTags = $tags->find("tag_question_id", $dbQuestion->id);
    //     // var_dump($dbTags);
    //
    //
    //
    //     $form = new DeleteUserForm($this->di, $id);
    //     $form->check();
    //
    //     $page->add("user/crud/delete", [
    //         "form" => $form->getHTML(),
    //     ]);
    //
    //     return $page->render([
    //         "title" => "Delete an item",
    //     ]);
    // }

    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->di->get("page");
        $form = new DeleteQuestionForm($this->di);
        $form->check();

        $page->add("question/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateQuestionForm($this->di, $id);
        $form->check();

        $page->add("question/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
