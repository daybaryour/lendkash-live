<?php

return [
    'paths' => [
        "/get-rating-requests/{type}" => [
            "get" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "Get rating loan request",
                "description" => "Get rating loan request",
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
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "Bearer {token}",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "type",
                        "in" => "path",
                        "description" => "type",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",
                        "enum" => ["borrower", "lender"]
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]

        ],

        "/get-request-lenders/{request_id}" => [
            "get" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "Get request lenders",
                "description" => "Get request lenders",
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
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "Bearer {token}",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "request_id",
                        "in" => "path",
                        "description" => "request id",
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
        "/get-rating-detail/{user_id}/{request_id}" => [
            "get" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "Get rating detail",
                "description" => "Get rating detail",
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
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "Bearer {token}",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "user_id",
                        "in" => "path",
                        "description" => "user id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "request_id",
                        "in" => "path",
                        "description" => "request id",
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
        "/submit-rating-review" => [
            "post" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "Submit rating and review",
                "description" => "Submit rating and review",
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
                        "name" => "to_id",
                        "in" => "formData",
                        "description" => "id who get rating ",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "request_id",
                        "in" => "formData",
                        "description" => "request id ",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "rating",
                        "in" => "formData",
                        "description" => "rating for request (1,2,3,4,5)",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "review",
                        "in" => "formData",
                        "description" => "review for request",
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

    ],
    'definitions' => [

    ]
];
