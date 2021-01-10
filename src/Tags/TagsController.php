<?php

namespace Bjos\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\Tags\HTMLForm\CreateForm;
use Bjos\Tags\HTMLForm\EditForm;
use Bjos\Tags\HTMLForm\DeleteForm;
use Bjos\Tags\HTMLForm\UpdateForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
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
        $this->question = $this->di->get("question");
        $this->user = $this->di->get("user");
        $this->session = $this->di->get("session");
    }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));

        $page->add("tags/crud/view-all", [
            "items" => $tags->findAllSelectParam("DISTINCT text"),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function tagActionGet() : object
    {
        $request = $this->di->get("request");
        $tag = $request->getGet("name");
        $page = $this->di->get("page");
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));
        $question = $this->question;
        $question->setDb($this->di->get("dbqb"));

        $tagsFound = $tags->findAllWhere("text = ? AND DELETED IS NULL", $tag);
        // var_dump($tagsFound);

        $foundQuestions = [];

        if (isset($tagsFound)) {
            foreach ($tagsFound as $value) {
                // var_dump($value->tagquestionid);
                $question->findWhere("id = ? AND DELETED IS NULL", $value->tagquestionid);
                $res = [
                    "id" => $question->id,
                    "username" => $question->username,
                    "title" => $question->title,
                    "text" => $question->text,
                    "vote" => $question->vote,
                    "created" => $question->created,
                ];
                // var_dump($question);

                array_push($foundQuestions, $res);
                // var_dump($foundQuestions);
                // $question = null;
            }
        }

        $page->add("tags/tag", [
            "title" => $tag,
            "items" => $foundQuestions,
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
    public function createAction(int $id) : object
    {
        $question = $this->question;
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $id);

        $validate = $this->user->checkLoggedInUser($this->di, $quest->username);

        if (!$validate) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $page = $this->di->get("page");
        $form = new CreateForm($this->di, $id);
        $form->check();

        $page->add("tags/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction(int $id) : object
    {
        $question = $this->question;
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $id);

        $validate = $this->user->checkLoggedInUser($this->di, $quest->username);

        if (!$validate) {
            return $this->di->get("response")->redirect("user/login")->send();
        }

        $page = $this->di->get("page");
        $form = new DeleteForm($this->di, $id);
        $form->check();

        $page->add("tags/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }


    //
    // /**
    //  * Handler with form to update an item.
    //  *
    //  * @param int $id the id to update.
    //  *
    //  * @return object as a response object
    //  */
    // public function updateAction(int $id) : object
    // {
    //     $page = $this->di->get("page");
    //     $form = new UpdateForm($this->di, $id);
    //     $form->check();
    //
    //     $page->add("tags/crud/update", [
    //         "form" => $form->getHTML(),
    //     ]);
    //
    //     return $page->render([
    //         "title" => "Update an item",
    //     ]);
    // }
}
