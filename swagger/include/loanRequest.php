<?php

return [
    'paths' => [
        "/loan-requests" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Get loan requests",
                "description" => "Get loan requests (Home page)",
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
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]

        ],
        "/request-detail/{id}" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Request details",
                "description" => "Request details",
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
                        "name" => "id",
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
        "/cancel-loan-request/{id}" => [
            "post" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Cancel loan request",
                "description" => "Cancel loan request",
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
                        "name" => "id",
                        "in" => "path",
                        "description" => "request id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "cancelled_reason",
                        "in" => "formData",
                        "description" =>"Cancelled reason",
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
        "/accept-loan-request" => [
            "post" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Accept loan request",
                "description" => "Accept loan request by lender",
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
                        "description" => "Request id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "amount",
                        "in" => "formData",
                        "description" => "Amount",
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
        "/reject-loan-request/{id}" => [
            "delete" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Reject loan request",
                "description" => "Reject loan request by lender",
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
                        "name" => "id",
                        "in" => "path",
                        "description" => "Request id",
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



        "/get-loan-term" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Get loan term",
                "description" => "Get loan terms",
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
        "/calculate-EMI" => [
            "post" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Calculate EMI",
                "description" => "Calculate EMI for send loan request",
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
                        "name" => "loan_term_id",
                        "in" => "formData",
                        "description" => "loan term id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],


                    [
                        "name" => "payment_frequency",
                        "in" => "formData",
                        "description" => "(monthly or weekly)",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "total_amount",
                        "in" => "formData",
                        "description" => "total amount",
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

        "/pay-loan-emi" => [
            "post" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Pay EMI",
                "description" => "Pay EMI",
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
                        "description" => "loan id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],


                    [
                        "name" => "emi_id",
                        "in" => "formData",
                        "description" => "EMI Id",
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
        "/request-loan" => [
            "post" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "Send loan request",
                "description" => "Send loan request to lenders",
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
                        "name" => "loan_term_id",
                        "in" => "formData",
                        "description" => "loan term id",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "loan_request_amount",
                        "in" => "formData",
                        "description" => "loan term amount",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "name" => "payment_frequency",
                        "in" => "formData",
                        "description" => "(monthly or weekly)",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "loan_description",
                        "in" => "formData",
                        "description" => "loan description",
                        "required" => false,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "okra_log",
                        "in" => "formData",
                        "description" => "okra log",
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
        "/my-loan-requests/{type}" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "My loan requests",
                "description" => "My loan requests",
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
                        "enum" => ["pending", "approved", "past", "active", "completed"]
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]

        ],


        "/investments" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "My loan investments",
                "description" => "My loan investments",
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
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]

        ],
        "/investment-details/{id}" => [
            "get" => [
                "tags" => [
                    "loan"
                ],
                "summary" => "My investment detail",
                "description" => "My investment detail",
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
                        "name" => "id",
                        "in" => "path",
                        "description" => "request id",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",

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
                "restaurant_id" => [
                    "type" => "integer"
                ],
                "action" => [
                    "type" => "string",
                     "enum" => ["favorite", "unfavorite"]
                ],
            ],
        ],
    ]
];
