<?php

return [
    'paths' => [

        "/inbox-chat" => [
            "post" => [
                "tags" => [
                    "chat"
                ],
                "summary" => "Inbox list",
                "description" => "Inbox list",
                "consumes" => [
                    "multipart/form-data"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],
                "parameters" => [
                    [
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "Bearer {token}",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "keyword",
                        "in" => "formData",
                        "description" => "keyword",
                        "required" => false,
                        "type" => "string",
                        "format" => "int64"
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],
        "/get-chat/{inbox_id}" => [
            "get" => [
                "tags" => [
                    "chat"
                ],
                "summary" => "Get chat by inbox id",
                "description" => "Get chat by inbox id",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],
                "parameters" => [
                    [
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "Bearer {token}",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "inbox_id",
                        "in" => "path",
                        "description" => "inbox_id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],





    ],
    'definitions' => [
        'restaurantFavoriteUnfavorite' => [
            "type" => "object",
            'properties' => [

            ],
        ],
    ]
];
