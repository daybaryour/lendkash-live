<?php

return [
    'paths' => [
        "/create-payment" => [
            "post" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Create Payment",
                "description" => "Create Payment",
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
                        "name" => "amount",
                        "in" => "formData",
                        "description" => "Amount",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "currency",
                        "in" => "formData",
                        "description" => "currency",
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
        "/save-payment" => [
            "post" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Create Payment",
                "description" => "Create Payment",
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
                        "name" => "payment_id",
                        "in" => "formData",
                        "description" => "Payment Id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "payment_type",
                        "in" => "formData",
                        "description" => "Payment Type",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",
                        "enum" => ["card", "account"]
                    ],
                    [
                        "name" => "card_number",
                        "in" => "formData",
                        "description" => "Card Number",
                        "required" => false,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "rave_response",
                        "in" => "formData",
                        "description" => "Rave Response",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64",
                        "enum" => ["failed", "success"]
                    ],
                    [
                        "name" => "json_data",
                        "in" => "formData",
                        "description" => "Json Data",
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
        "/delete-save-card/{card_id}" => [
            "delete" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Delete Card",
                "description" => "Delete Card",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "name" => "Authorization",
                        "in" => "header",
                        "description" => "token",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "card_id",
                        "in" => "path",
                        "description" => "Card Id",
                        "required" => true,
                        "type" => "integer",
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
        "/get-saved-cards" => [
            "get" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Get user saved cards",
                "description" => "Get user saved cards",
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
        "/check-transfer-commission" => [
            "post" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Check Transfer Commission",
                "description" => "Check Transfer Commission",
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
        "/create-bank-transfer" => [
            "post" => [
                "tags" => [
                    "payment"
                ],
                "summary" => "Create Bank Transfer",
                "description" => "Create Bank Transfer",
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
                        "name" => "bank_code",
                        "in" => "formData",
                        "description" => "Bank Code",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "account_number",
                        "in" => "formData",
                        "description" => "Account Number",
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
                    [
                        "name" => "beneficiary_name",
                        "in" => "formData",
                        "description" => "Beneficiary Name",
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
