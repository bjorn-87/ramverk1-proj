<?php

namespace Bjos\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create user",
            ],
            [
                "email" => [
                    "type"        => "email",
                    "validation" => ["not_empty"],
                ],

                "username" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                ],

                "password" => [
                    "type"        => "password",
                    "validation" => ["not_empty"],
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $email       = $this->form->value("email");
        $username       = $this->form->value("username");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->email = $email;
        $user->username = $username;
        $user->created = date('Y-m-d H:i:s');
        $user->setPassword($password);

        try {
            $user->save();
        } catch (\Exception $e) {
            $this->form->addOutput("Username or email already exist.");
            return false;
        }

        $this->form->addOutput("User was created.");
        return true;
    }

    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/login")->send();
    }
}
