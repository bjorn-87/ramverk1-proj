<?php

namespace Bjos\Comment;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\Comment\HTMLForm\CreateCommentForm;
use Bjos\Comment\AnswerComment;
use Bjos\Comment\QuestionComment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class CommentController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    private $textfilter;
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
        $this->request = $this->di->get("request");
        $this->session = $this->di->get("session");
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
        $request = $this->request;

        $id = $request->getGet("id");
        $type = $request->getGet("type");
        $questId = $request->getGet("questid", null);

        if (empty($user)) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $form = new CreateCommentForm($this->di, $id, $type, $questId);
        $form->check();

        $page->add("comment/crud/create", [
            "form" => $form->getHTML(),
            "id" => $id,
            "questId" => $questId,
        ]);

        return $page->render([
            "title" => "Kommentar",
        ]);
    }
}
