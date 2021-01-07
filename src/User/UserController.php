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
    private $gravatar;



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
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $gravatar = $this->gravatar;

        // var_dump($this->di->session->get("user"));
        $page->add("user/crud/view-all", [
            "items" => $user->findAll(),
            "gravatar" => $gravatar,
        ]);

        return $page->render([
            "title" => "A collection of items",
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
    public function loginAction() : object
    {
        $loggedIn = $this->session->get("user");

        if (isset($loggedIn)) {
            $this->di->get("response")->redirect("")->send();
        }

        $page = $this->di->get("page");
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
        $page = $this->di->get("page");
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
        $page = $this->di->get("page");
        $user = $this->session->get("user", null);

        if (!$user) {
            $this->di->get("response")->redirect("user/login")->send();
        }

        $id = isset($user) ? $user["id"] : null;
        $form = new DeleteUserForm($this->di, $id);
        $form->check();

        // var_dump($this->di->session->get("user"));
        // $this->di->get("session")->set("user", null);

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

        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("user/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }

    /**
     * Userpage
     *
     * @param int $id the id to update.
     *
     * @return void
     */
    public function userPageAction($username) : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $gravatar = $this->gravatar;

        if (!$user) {
            $this->di->get("response")->redirect("user/login")->send();
        }

        $currentUser = $user->checkLoggedInUser($this->di, $username);

        if ($currentUser) {
            $userPage = "user/userpageadmin";
        } else {
            $userPage = "user/userpage";
        }

        $page->add($userPage, [
            "items" => $user->find("username", $username),
            "gravatar" => $gravatar->getGravatar($user->email),
        ]);

        return $page->render([
            "title" => "A collection of items",
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
