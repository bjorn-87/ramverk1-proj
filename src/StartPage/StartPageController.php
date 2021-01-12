<?php

namespace Bjos\StartPage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class StartPageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * @var $data description
     */
    private $tags;
    private $session;
    private $question;
    private $user;
    private $textfilter;


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
        $this->question = $this->di->get("question");
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $flash = $this->session->getOnce("flash");

        $question = $this->question;
        $question->setDb($this->di->get("dbqb"));

        $topUsers = $question->findTopForStartPage(
            "COUNT(id) AS amount, username",
            "username",
            "amount"
        );

        $latestQuestions = $question->findAllNotDeletedLimit();

        $tags = $this->tags;
        $tags->setDb($this->di->get("dbqb"));
        $topTags = $tags->findTopForStartPage(
            "COUNT(id) AS amount, text",
            "text",
            "amount"
        );

        $page->add("startpage/flashmessage", [
            "flash" => $flash,
        ], "flash-message");

        $page->add("startpage/startpage", [

            "questions" => $latestQuestions,
        ], "main", 1);

        $page->add("startpage/sidebar-right", [
            "users" => $topUsers,
            "tags" => $topTags,
        ], "sidebar-right", 2);

        return $page->render([
            "title" => "Start",
        ]);
    }
}
