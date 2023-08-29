<?php

return [
    'paths' => [
        "/get-invest-term" => [
            "get" => [
                "tags" => [
                    "invest"
                ],
                "summary" => "Get invest term",
                "description" => "Get invest terms",
                // "operationId" => "login",
                "consumes" => [
                    "multipart/form-data"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],

                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]

        ],
        "/calculate-maturity" => [
            "post" => [
                "tags" => [
                    "invest"
                ],
                "summary" => "Calculate Maturity",
                "description" => "Calculate maturity amount for invest request",
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
                        "name" => "invest_term_id",
                        "in" => "formData",
                        "description" => "invest term id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "name" => "invest_amount",
                        "in" => "formData",
                        "description" => "invest amount",
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


        "/request-invest" => [
            "post" => [
                "tags" => [
                    "invest"
                ],
                "summary" => "Send invest request",
                "description" => "Send invest request",
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
                        "name" => "invest_term_id",
                        "in" => "formData",
                        "description" => "loan term id",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "invest_amount",
                        "in" => "formData",
                        "description" => "invest term amount",
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
        "/my-invest-requests/{type}" => [
            "get" => [
                "tags" => [
                    "invest"
                ],
                "summary" => "My invest requests",
                "description" => "My invest requests",
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
                        "enum" => ["pending", "approved", "past"]
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
