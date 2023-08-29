<?php

return [
    'paths' => [
        "/support-request" => [
            "post" => [
                "tags" => [
                    "setting"
                ],
                "summary" => "Send support request",
                "description" => "Send support request",
                // "operationId" => "login",
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
                        "name" => "request_id",
                        "in" => "formData",
                        "description" => "loan request id",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "title",
                        "in" => "formData",
                        "description" => "request title",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "description",
                        "in" => "formData",
                        "description" => "request description",
                        "required" => true,
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
        "/get-cms-detail/{type}" => [
            "get" => [
                "tags" => [
                    "setting"
                ],
                "summary" => "Get Cms Detail",
                "description" => "Get Cms Detail",
                // "operationId" => "login",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],


                "parameters" => [
                    [
                        "name" => "type",
                        "in" => "path",
                        "description" => "type",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",
                        "enum" => ["about", "terms_and_condition", "privacy_policy","faq","description"]
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

    ]
];
