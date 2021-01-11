<?php

namespace Bjos\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\Question\HTMLForm\CreateQuestionForm;
use Bjos\Question\HTMLForm\DeleteQuestionForm;
use Bjos\Question\HTMLForm\UpdateQuestionForm;
use Bjos\Answer\HTMLForm\CreateAnswerForm;
use Bjos\Answer\HTMLForm\DeleteAnswerForm;
use Bjos\Answer\HTMLForm\UpdateAnswerForm;
// use Bjos\Comment\HTMLForm\CreateCommentForm;
// use Bjos\Comment\HTMLForm\DeleteCommentForm;
// use Bjos\Comment\HTMLForm\UpdateCommentForm;
use Bjos\Comment\AnswerComment;
use Bjos\Comment\QuestionComment;

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
        $this->answer = $this->di->get("answer");
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

        $items = $question->findAllPaginate($limit, $offset);
        $data = [];

        if ($items) {
            foreach ($items as $value) {
                array_push($data, [
                    "id" => $value->id,
                    "username" => $this->textfilter->parse($value->username, ["purify"]),
                    "title" => $this->textfilter->parse($value->title, ["purify"]),
                    "text" => $this->textfilter->parse($value->text, ["purify", "markdown"]),
                    "vote" => $value->vote,
                    "answers" => $value->answers,
                    "created" => $value->created,
                    "updated" => $value->updated,
                    "deleted" => $value->deleted,
                    "tags" => $tags->findAllWhere("tagquestionid = ? AND DELETED IS NULL", $value->id),
                ]);
            }
        }

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
    public function questidAction(int $questid) : object
    {
        $page = $this->di->get("page");
        $user = $this->session->get("user");

        // Get Question
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $questid);

        // Get Tags
        $tags = $this->tags;
        $tags->setDb($this->di->get("dbqb"));
        $allTags = $tags->findAllNotDeleted("tagquestionid = ?", $questid);

        $items = [
            "id" => $quest->id,
            "username" => $this->textfilter->parse($quest->username, ["purify"])->text,
            "title" => $this->textfilter->parse($quest->title, ["purify"])->text,
            "text" => $this->textfilter->parse($quest->text, ["purify", "markdown"])->text,
            "vote" => $quest->vote,
            "answers" => $quest->answers,
            "created" => $quest->created,
            "updated" => $quest->updated,
        ];

        $validate = $this->user->checkLoggedInUser($this->di, $quest->username);

        // Get Answers
        $answer = $this->answer;
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllNotDeleted("questionid = ?", $questid);

        // Get Questioncomment
        $qComment = new QuestionComment();
        $qComment->setDb($this->di->get("dbqb"));
        $qComments = $qComment->findAllNotDeleted("commentquestionid = ?", $questid);

        $qComments = $question->markdownParse($this->di, $qComments, ["purify", "markdown"]);

        // Get Answercomment
        foreach ($answers as $ans) {
            $aComment = new AnswerComment();
            $aComment->setDb($this->di->get("dbqb"));
            $ans->aComment = $aComment->findAllNotDeleted("answerid = ?", $ans->id);
            $ans->text = $this->textfilter->parse($ans->text, ["purify", "markdown"])->text;
            $ans->aComment = $question->markdownParse($this->di, $ans->aComment, ["purify", "markdown"]);
        }

        // var_dump($answers);

        $page->add("question/questid", [
            "items" => $items,
            "answers" => $answers,
            "qComments" => $qComments,
            "tags" => $allTags,
            "loggedIn" => isset($user) ? true : false,
            "questId" => $questid,
        ]);

        // Admin cannot answer its own question
        if (isset($user) && !$validate) {
            $answerForm = new CreateAnswerForm($this->di, $questid);
            $answerForm->check();
            $page->add("question/answerform", [
                "answerForm" => $answerForm->getHTML(),
            ]);
        }

        if ($validate) {
            $page->add("question/questidAdmin", [
                "id" => $questid,
            ]);
        }

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

    // /**
    //  * Handler with form to delete an item.
    //  *
    //  * @return object as a response object
    //  */
    // public function deleteAction() : object
    // {
    //     $page = $this->di->get("page");
    //     $form = new DeleteQuestionForm($this->di);
    //     $form->check();
    //
    //     $page->add("question/crud/delete", [
    //         "form" => $form->getHTML(),
    //     ]);
    //
    //     return $page->render([
    //         "title" => "Delete an item",
    //     ]);
    // }



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
