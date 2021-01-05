<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Forum",
            "url" => "",
            "title" => "Forum",
        ],
        [
            "text" => "Användare",
            "url" => "user",
            "title" => "användare",
        ],
        [
            "text" => "Login",
            "url" => "user/login",
            "title" => "Logga in",
        ],
        [
            "text" => "Skapa konto",
            "url" => "user/create",
            "title" => "Skapa konto",
        ],
    ],
];
