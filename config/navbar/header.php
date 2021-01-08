<?php
/**
 * Supply the basis for the navbar as an array.
 */

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"]["username"];
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
                "url" => "forum",
                "title" => "Forum",
                "submenu" => [
                    "items" => [
                        [
                            "text" => "Frågor",
                            "url" => "question",
                            "title" => "Frågor",
                        ],
                        [
                            "text" => "Taggar",
                            "url" => "tags",
                            "title" => "Taggar",
                        ],
                    ],
                ],
            ],
            [
                "text" => "Användare",
                "url" => "userpage",
                "title" => "användare",
            ],
            [
                "text" => "Konto",
                "url" => "userpage/user/{$user}",
                "title" => "Konto",
            ],
            [
                "text" => "Logga ut",
                "url" => "user/logout",
                "title" => "Logga ut",
            ],
        ],
    ];
}

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
            "url" => "forum",
            "title" => "Forum",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Frågor",
                        "url" => "question",
                        "title" => "Frågor",
                    ],
                    [
                        "text" => "Taggar",
                        "url" => "tags",
                        "title" => "Taggar",
                    ],
                ],
            ],
        ],
        [
            "text" => "Användare",
            "url" => "userpage",
            "title" => "användare",
        ],
        [
            "text" => "Login",
            "url" => "user/login",
            "title" => "Logga in",
        ]
    ],
];
