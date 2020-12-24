<?php

return [

    'laravel_modules' => [

        'lang' => 'English',

        'module' => [

            'search' => [
                'select' => '请选择',
                'created_at' => '创建日期'
            ],
            'list' => [
                'name' => '名称',
                'alias' => '别名',
                'description' => '描述',
                'priority' => '优先级',
                'version' => '版本号',
                'path' => '文件路径',
                'type' => '类型',
                'sort' => '排序',
                'status' => '状态',
                'created_at' => '添加时间',
                'updated_at' => '更新时间',
                'action' => '操作',
            ],
            'form' => [
                'btn'=> [
                    'create' => '新增系统模块',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'submit' => '提交',
                    'reset' => '重置',
                ]
            ],
            'field' => [
                'name' => '名称',
                'alias' => '别名',
                'description' => '描述',
                'priority' => '优先级',
                'version' => '版本号',
                'path' => '文件路径',
                'type' => '类型',
                'type_1' => '内核',
                'type_2' => '扩展',
                'sort' => '排序',
                'status' => '状态',
                'status_enable' => '启用',
                'status_disable' => '禁用',
            ]
        ],
        'msg' => [
            'removable' => '确定删除？'
        ]
    ],

    'welcome' => [
        'name' => '首页',
        'title' => '欢迎',
        'links' => [
            'welcome' => [
                'name' => ':user，欢迎您'
            ],
            'front' => [
                'name' => '用户登录'
            ],
            'admin' => [
                'name' => '管理员登录'
            ],
            'member' => [
                'sign' => [
                    'in' => [
                        'name' => '登录'
                    ],
                    'out' => [
                        'name' => '退出登录'
                    ],
                    'up' => [
                        'name' => '注册'
                    ]
                ]
            ]
        ]
    ],

    'admin' => [
        'login' => [
            'name' => '登录',
            'form' => [
                'account' => '账号',
                'password' => '密码',
                'captcha' => '图形验证码',
                'fresh_captcha' => '点击刷新验证码',
                'submit' => '登录'
            ]
        ],
        'sign' => [
            'in' => [
                'name' => '登录',
                'tip' => '已有账号？'
            ],
            'out' => [
                'name' => '登出'
            ],
            'up' => [
                'name' => '注册'
            ]
        ],
        'list' => [
            'create' => [
                'name' => '新增'
            ]
        ]
    ]



];
