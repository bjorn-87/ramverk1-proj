<?php

namespace Bjos\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\Question\HTMLForm\CreateQuestionForm;
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
    private $textfilter;
    private $tags;
    private $session;


    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->textfilter = $this->di->get("textfilter");
        $this->tags = $this->di->get("tags");
        $this->session = $this->di->get("session");
        $this->user = $this->di->get("user");
        $this->title = "Ändras";
    }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $tags = $this->tags;
        $tags->setDb($this->di->get("dbqb"));

        $limit = $request->getGet("limit", 4);
        if (!(is_numeric($limit) && $limit > 0 && $limit <= 8)) {
            return $this->di->get("response")->redirect("question")->send();
        }

        $total = $question->countTotal("DELETED IS NULL");
        $max = ceil($total->total / $limit);

        $paginate = $request->getGet("page", 1);
        if (!(is_numeric($limit) && $paginate > 0 && $paginate <= $max)) {
            $this->session->set("max", $max);
            return $this->di->get("response")->redirect("question")->send();
        }
        $offset = $limit * ($paginate - 1);
        //
        // var_dump($_GET);
        // var_dump($_SESSION);
        // $items = $question->findAllWhere("DELETED IS NULL", []);
        $items = $question->findAllPaginate($limit, $offset);
        $data = [];

        // var_dump($max);
        if ($items) {
            foreach ($items as $value) {
                array_push($data, [
                    "id" => $value->id,
                    "username" => $value->username,
                    "title" => $this->textfilter->parse($value->title, ["purify"]),
                    "text" => $this->textfilter->parse($value->text, ["purify", "markdown"]),
                    "vote" => $value->vote,
                    "created" => $value->created,
                    "updated" => $value->updated,
                    "deleted" => $value->deleted,
                    "tags" => $tags->findAllWhere("tagquestionid = ? AND DELETED IS NULL", $value->id),
                ]);
                // var_dump($value->id);
                // $items[$key]->text = ($this->textfilter->parse($value, ["markdown"]));
            }
        }
        // var_dump($data);

        $page->add("question/crud/view-all", [
            "items" => $data,
            "max" => $max,
        ]);

        return $page->render([
            "title" => "$this->title | Alla frågor",
        ]);
    }


    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function questidActionGet(int $questid) : object
    {
        // $request = $this->di->get("request");
        $page = $this->di->get("page");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $questid);

        $validate = $this->user->checkLoggedInUser($this->di, $quest->username);

        $addPage = $validate ? "question/questidAdmin" : "question/questid";

        // $question = new Question();
        // $question->setDb($this->di->get("dbqb"));
        // $tags = $this->tags;
        // $tags->setDb($this->di->get("dbqb"));
        $data = [];

        $page->add($addPage, [
            "items" => $data,
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
        $user = $this->session->get("user");

        if (empty($user)) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $form = new CreateQuestionForm($this->di, $user["username"]);
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
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $id);

        $validate = $this->user->checkLoggedInUser($this->di, $quest->username);

        if (!$validate) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $page = $this->di->get("page");
        $form = new UpdateQuestionForm($this->di, $id);
        $form->check();

        $page->add("question/crud/update", [
            "form" => $form->getHTML(),
            "id" => $id,
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
