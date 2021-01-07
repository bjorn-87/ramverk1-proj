<?php

namespace Bjos\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Bjos\User\User;

/**
 * Form to update an item.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "number",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->username,
                ],

                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],

                "firstname" => [
                    "type" => "text",
                    "value" => $user->firstname,
                ],

                "surname" => [
                    "type" => "text",
                    "value" => $user->surname,
                ],

                "old-password" => [
                    "type" => "password"
                ],

                "new-password" => [
                    "type" => "password"
                ],

                "new-password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "new-password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return User
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $email = $this->form->value("email");
        $oldPassword = $this->form->value("old-password");
        $newPassword = $this->form->value("new-password");
        $newPasswordAgain = $this->form->value("new-password-again");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));

        $user->email = $this->form->value("email");
        $user->firstname = $this->form->value("firstname");
        $user->surname = $this->form->value("surname");


        // Check password matches
        if ($newPassword) {
            $res = $user->verifyPassword($user->username, $oldPassword);

            if (!$res) {
                $this->form->rememberValues();
                $this->form->addOutput("Old password did not match.");
                return false;
            }

            if ($newPassword !== $newPasswordAgain) {
                $this->form->rememberValues();
                $this->form->addOutput("Password did not match.");
                return false;
            }
            $user->setPassword($newPassword);
        }

        $user->email = $email;
        $user->updated = date('Y-m-d H:i:s');
        $user->save();

        $this->di->session->set("user", [
            "id" => $user->id,
            "username" => $user->username,
            "email" => $user->email,
            "role" => $user->role,
        ]);

        return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("user")->send();
    //     //$this->di->get("response")->redirect("user/update/{$user->id}");
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
