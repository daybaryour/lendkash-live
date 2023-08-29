<?php

return [
    'paths' => [
        "/check-user-exist" => [
            "post" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Check mobile number exist for send request",
                "description" => "Check mobile number exist for send request",
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
                        "name" => "mobile_number",
                        "in" => "formData",
                        "description" => "Mobile number",
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


        "/send-money-request" => [
            "post" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Send money request",
                "description" => "Send money request",
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
                        "name" => "user_id",
                        "in" => "formData",
                        "description" => "user id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "name" => "amount",
                        "in" => "formData",
                        "description" => "Amount",
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


        "/recent-money-transaction" => [
            "get" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Recent money transaction",
                "description" => "Recent money transaction",
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
        "/pay-request-money" => [
            "post" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Pay requested money",
                "description" => "Pay requested money",
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
                        "description" => "Wallet request id",
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

        "/pay-money" => [
            "post" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Pay money",
                "description" => "Pay money",
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
                        "description" => "to id",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "amount",
                        "in" => "formData",
                        "description" => "amount",
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

        "/wallet-transactions/{type}" => [
            "get" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Wallet transactions",
                "description" => "Wallet transactions",
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
                        "name" => "type",
                        "in" => "path",
                        "description" => "type",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",
                        "enum" => ["received", "sent", "amount_received_via_emi",'invest','loan_requested','add_money','bank_transfer']

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
