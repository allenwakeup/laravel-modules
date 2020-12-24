<?php

return [



    'laravel_modules' => [

        'lang' => '简体中文',

        'module' => [

            'search' => [
                'select' => 'Please select',
                'created_at' => 'Created At'
            ],
            'list' => [
                'name' => 'Name',
                'alias' => 'Alias',
                'description' => 'Desc',
                'priority' => 'Priority',
                'version' => 'Version',
                'path' => 'File Path',
                'type' => 'Type',
                'sort' => 'Sort',
                'status' => 'Status',
                'created_at' => 'Created On',
                'updated_at' => 'Last Modified',
                'action' => 'Action',
            ],
            'form' => [
                'btn'=> [
                    'create' => 'Create New',
                    'edit' => 'Edit',
                    'delete' => 'Remove',
                    'submit' => 'Submit',
                    'reset' => 'Reset',
                ],

            ],
            'field' => [
                'name' => 'Name',
                'alias' => 'Alias',
                'description' => 'Desc',
                'priority' => 'Priority',
                'version' => 'Version',
                'path' => 'File Path',
                'type' => 'Type',
                'type_1' => 'System',
                'type_2' => 'Extended',
                'sort' => 'Sort',
                'status' => 'Status',
                'status_enable' => 'Enable',
                'status_disable' => 'Disable',
            ]
        ],
        'msg' => [
            'removable' => 'Are you sure about remove it?'
        ]
    ],

    'welcome' => [
        'name' => 'Welcome',
        'title' => 'Welcome',
        'links' => [
            'welcome' => [
                'name' => 'Welcome, :user'
            ],
            'front' => [
                'name' => 'User Login'
            ],
            'admin' => [
                'name' => 'Admin Login'
            ],
            'member' => [
                'sign' => [
                    'in' => [
                        'name' => 'Sign In'
                    ],
                    'out' => [
                        'name' => 'Sign Out'
                    ],
                    'up' => [
                        'name' => 'Sign Up'
                    ]
                ]
            ]
        ]
    ],

    'admin' => [
        'login' => [
            'name' => 'Sign In',
            'form' => [
                'account' => 'User Name',
                'password' => 'Password',
                'captcha' => 'Verify Code',
                'fresh_captcha' => 'Click to refresh',
                'submit' => 'Login'
            ]
        ],
        'sign' => [
            'in' => [
                'name' => 'Sign In',
                'tip' => 'Existing customer?'
            ],
            'out' => [
                'name' => 'Sign Out'
            ],
            'up' => [
                'name' => 'Sign Up'
            ]
        ]
    ]


];
