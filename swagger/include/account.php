<?php

return [
    'paths' => [
        "/register" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "register",
                "description" => "create account",
                "consumes" => [
                    "multipart/form-data"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],
                "parameters" => [

                    [
                        "name" => "name",
                        "in" => "formData",
                        "description" => "Name",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "email",
                        "in" => "formData",
                        "description" => "Email",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "password",
                        "in" => "formData",
                        "description" => "Password",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "mobile_number",
                        "in" => "formData",
                        "description" => "Mobile Number",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "in" => "formData",
                        "name" => "user_image",
                        "description" => "user image",
                        "required" => false,
                        "type" => "file",
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
//        "/account-verification/{code}" => [
//            "get" => [
//                "tags" => [
//                    "account"
//                ],
//                "summary" => "account verification",
//                "description" => "account verification",
//                "consumes" => [
//                    "application/json"
//                ],
//                "produces" => [
//                    "application/json"
//                ],
//                "parameters" => [
//
//                        [
//                            "name" => "code",
//                            "in" => "path",
//                            "description" => "code",
//                            "required" => true,
//                            "type" => "integer"
//                        ]
//
//
//                ],
//                "responses" => [
//                    "default" => [
//                        "description" => "successful operation"
//                    ]
//                ]
//            ]
//        ],
//        "/resend-verification-code/{email}" => [
//            "get" => [
//                "tags" => [
//                    "account"
//                ],
//                "summary" => "resend verification code",
//                "description" => "resend verification code",
//                "consumes" => [
//                    "application/json"
//                ],
//                "produces" => [
//                    "application/json"
//                ],
//                "parameters" => [
//
//                        [
//                            "name" => "email",
//                            "in" => "path",
//                            "description" => "email",
//                            "required" => true,
//                            "type" => "string"
//                        ]
//
//
//                ],
//                "responses" => [
//                    "default" => [
//                        "description" => "successful operation"
//                    ]
//                ]
//            ]
//        ],
        "/login" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "login",
                "description" => "login",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "login",
                        "required" => true,
                        "schema" => [
                                '$ref' => "#/definitions/login"
                        ]
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],
         "/send-otp" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "Login with phone number",
                "description" => "Login with phone number or email",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Send OTP on register number",
                        "required" => true,
                        "schema" => [
                                '$ref' => "#/definitions/sendotp"
                        ]
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],
        "/verify-otp" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "Verify OTP",
                "description" => "Verify OTP",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Verify OTP",
                        "required" => true,
                        "schema" => [
                                '$ref' => "#/definitions/verifyotp"
                        ]
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],
        "/forgot-password/{email}" => [
            "get" => [
                "tags" => [
                    "account"
                ],
                "summary" => "forgot password",
                "description" => "forgot password",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [

                        [
                            "name" => "email",
                            "in" => "path",
                            "description" => "email",
                            "required" => true,
                            "type" => "string"
                        ]


                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ]
            ]
        ],
        "/reset-password" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "reset password",
                "description" => "reset password",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "reset password by code",
                        "required" => true,
                        "schema" => [
                                '$ref' => "#/definitions/resetPassword"
                        ]
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

        'register' => [
            "type" => "object",
            'properties' => [
                "name" => [
                    "type" => "string"
                ],
                "email" => [
                    "type" => "string"
                ],
                "password" => [
                    "type" => "string"
                ],
                "mobile_number" => [
                    "type" => "number"
                ],

            ],
        ],
        'login' => [
            "type" => "object",
            'properties' => [
                "email" => [
                    "type" => "string"
                ],
                "password" => [
                    "type" => "string"
                ],
                 'device_id' => [
                    'type' => 'string'
                ],
                'device_type' => [
                    'type' => 'string'
                ],
                'certification_type' => [
                    'type' => 'string'
                ]

            ],
        ],
        'sendotp'=>[
            "type" => "object",
            'properties' => [
                "email" => [
                    "type" => "string"
                ],
                "mobile_number" => [
                    "type" => "string"
                ],
            ],
        ],

        'verifyotp'=>[
            "type" => "object",
            'properties' => [
                "email" => [
                    "type" => "string"
                ],
                "mobile_number" => [
                    "type" => "string"
                ],
                "otp" => [
                    "type" => "number"
                ],
                 'device_id' => [
                    'type' => 'string'
                ],
                'device_type' => [
                    'type' => 'string'
                ],
                'certification_type' => [
                    'type' => 'string'
                ],


            ],
        ],

        'resetPassword'=>[
            "type" => "object",
            'properties' => [
                "code" => [
                    "type" => "number"
                ],
                "password" => [
                    "type" => "string"
                ],

            ],

        ],

    ]
];



