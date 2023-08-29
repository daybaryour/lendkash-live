<?php

return [
    'paths' => [

        "/countries" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Country list",
                "description" => "Country list",
                "consumes" => [
                    "application/json"
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

        "/states/{id}" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "State list",
                "description" => "State list",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],
                "parameters" => [

                    [
                        "name" => "id",
                        "in" => "path",
                        "description" => "country id",
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
        "/cities/{id}" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "city list",
                "description" => "city list",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    //"application/xml",
                    "application/json"
                ],
                "parameters" => [

                    [
                        "name" => "id",
                        "in" => "path",
                        "description" => "state id",
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
        "/complete-kyc-details" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Complete KYC details",
                "description" => "Complete KYC details",
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
                        "name" => "name",
                        "in" => "formData",
                        "description" => "Name",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "dob",
                        "in" => "formData",
                        "description" => "YYYY-mm-dd",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "address",
                        "in" => "formData",
                        "description" => "Address",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "employer_detail",
                        "in" => "formData",
                        "description" => "Employer Detail",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "country_id",
                        "in" => "formData",
                        "description" => "Country id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "state_id",
                        "in" => "formData",
                        "description" => "State id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],
                    [
                        "name" => "city_id",
                        "in" => "formData",
                        "description" => "City id",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "name" => "bank_name",
                        "in" => "formData",
                        "description" => "Bank name",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "bvn",
                        "in" => "formData",
                        "description" => "BVN",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "account_holder_name",
                        "in" => "formData",
                        "description" => "account holder name",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],

                    [
                        "name" => "account_number",
                        "in" => "formData",
                        "description" => "Account number",
                        "required" => true,
                        "type" => "integer",
                        "format" => "int64"
                    ],

                    [
                        "in" => "formData",
                        "name" => "id_proof_document",
                        "description" => "Id proof document",
                        "required" => false,
                        "type" => "file",
                        "format" => "int64"
                    ],
                    [
                        "in" => "formData",
                        "name" => "employment_document",
                        "description" => "employment document",
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
        "/view-kyc-details" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "View kyc",
                "description" => "View kyc details",
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


        "/change-password" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Change password",
                "description" => "Change password",
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
                        "name" => "current_password",
                        "in" => "formData",
                        "description" => "current password",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "new_password",
                        "in" => "formData",
                        "description" => "new password",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "confirm_password",
                        "in" => "formData",
                        "description" => "confirm password",
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

        "/settings" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Get user setting",
                "description" => "Get user setting",
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



        "/update-profile" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Update Profile",
                "description" => "Update Profile",
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
                        "description" => "token",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "user_image",
                        "in" => "formData",
                        "description" => "Profile image",
                        "required" => false,
                        "type" => "file",
                        "format" => "int64"
                    ],
                    [
                        "name" => "name",
                        "in" => "formData",
                        "description" => "Name",
                        "required" => true,
                        "type" => "string",
                        "format" => "int64"
                    ],
                    [
                        "name" => "address",
                        "in" => "formData",
                        "description" => "Address",
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


        "/notifications" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "notification list",
                "description" => "Notifications list",
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

        "/logout" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "logout",
                "description" => "Logout",
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
