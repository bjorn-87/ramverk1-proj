<?php

namespace Bjos\UserPage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\UserPage\UserPage;

// use Bjos\User\HTMLForm\CreateUserForm;
// use Bjos\User\HTMLForm\UpdateUserForm;
// use Bjos\User\HTMLForm\DeleteUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserPageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $data description
     */
    private $session;
    private $gravatar;
    private $user;
    private $question;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->session = $this->di->get("session");
        $this->gravatar = $this->di->get("gravatar");
        $this->user = $this->di->get("user");
        $this->question = $this->di->get("question");
        $this->answer = $this->di->get("answer");
        $this->aComment = $this->di->get("answercomment");
        $this->qComment = $this->di->get("questioncomment");
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $user = $this->user;
        $user->setDb($this->di->get("dbqb"));
        $gravatar = $this->gravatar;

        $page->add("user/crud/view-all", [
            "items" => $user->findAllWhere("deleted IS NULL", []),
            "gravatar" => $gravatar,
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Userpage
     *
     * @param int $id the id to update.
     *
     * @return void
     */
    public function userAction($username) : object
    {
        $page = $this->di->get("page");
        // get User
        $user = $this->user;
        $user->setDb($this->di->get("dbqb"));
        // Get answer
        $answer = $this->answer;
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("username = ?", [$username]);
        // Get Question
        $question = $this->question;
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("username = ?", [$username]);
        // Get Question comment
        $qComment = $this->qComment;
        $qComment->setDb($this->di->get("dbqb"));
        $qComments = $qComment->findAllWhere("username = ?", [$username]);
        // Get Answercomment
        $aComment = $this->aComment;
        $aComment->setDb($this->di->get("dbqb"));
        $aComments = $aComment->joinAnswerComment($username);

        $aComments = $question->markdownParse($this->di, $aComments, ["purify", "markdown"]);
        $qComments = $question->markdownParse($this->di, $qComments, ["purify", "markdown"]);
        $answers = $question->markdownParse($this->di, $answers, ["purify", "markdown"]);
        $questions = $question->markdownParse($this->di, $questions, ["purify", "markdown"]);
        // Get gravatar
        $gravatar = $this->gravatar;

        if (!$user) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $page->add("userpage/userpage", [
            "items" => $user->find("username", $username),
            "gravatar" => $gravatar->getGravatar($user->email),
            "acomments" => $aComments,
            "qcomments" => $qComments,
            "questions" => $questions,
            "answers" => $answers,
        ]);


        $currentUser = $this->user->checkLoggedInUser($this->di, $username);
        if ($currentUser) {
            $page->add("userpage/userpageadmin");
        }

        return $page->render([
            "title" => "Användarsida",
        ]);
    }
}
