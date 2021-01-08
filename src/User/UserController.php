<?php

namespace Bjos\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\User\HTMLForm\UserLoginForm;
use Bjos\User\HTMLForm\CreateUserForm;
use Bjos\User\HTMLForm\UpdateUserForm;
use Bjos\User\HTMLForm\DeleteUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    private $session;
    private $page;



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
        $this->page = $this->di->get("page");
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $loggedIn = $this->session->get("user");

        if (isset($loggedIn)) {
            $this->di->get("response")->redirect("")->send();
        }

        $page = $this->page;
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("user/login", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->page;
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("user/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa användare",
        ]);
    }

    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->page;
        $user = $this->session->get("user", null);

        if (!$user) {
            $this->di->get("response")->redirect("user/login")->send();
        }

        $id = $user["id"];

        $form = new DeleteUserForm($this->di, $id);
        $form->check();

        $page->add("user/crud/delete", [
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
    public function updateAction() : object
    {
        $user = $this->session->get("user", null);

        if (!$user) {
            $this->di->get("response")->redirect("user/login")->send();
        }

        $id = isset($user) ? $user["id"] : null;
        $username = isset($user) ? $user["username"] : null;

        $page = $this->page;
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("user/crud/update", [
            "form" => $form->getHTML(),
            "username" => $username,
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }

    /**
     * Log out account.
     *
     * @return void
     */
    public function logoutAction()
    {
        $this->di->session->set("user", null);
        $this->di->get("response")->redirect("")->send();
    }
}
