<?php


/**
 * Permissions config
 *
 * @date   23/10/2020
 */

return [

//    'Permissions'=>[
//        'Manage' =>
//            [ // 0
//            'title' => 'Pages',
//            'Modules' =>
//                [ // 0
//                    'View' => ['pages.index', 'api.pages.index'],
//                    'Add' => ['Add Pages View'],
//                    'Edit' => ['pages.index', 'api.pages.index'],
//                    'Update' => ['pages.index', 'api.pages.index'],
//                    'View' => ['pages.index', 'api.pages.index'],
//                ]
//         ]
//    ],

    'Dashboard' => [
        'main' => [
            'Dashboard View' => 'dashboard',
        ],
    ],

    'Manage'=> [
        'Pages' => [
            'View' => 'pages.index|api.pages.index',
            'Add' => 'pages.add|api.pages.store',
            'Edit' => 'pages.edit|api.pages.edit|api.pages.update',
            'Delete' => 'api.pages.delete',
            'Status' => 'api.pages.status',
            'Export' => 'api.pages.download'
        ],
        'News' => [
            'View' => 'news.index|api.news.index',
            'Add' => 'news.add|api.news.store',
            'Edit' => 'news.edit|api.news.edit|api.news.update',
            'Delete' => 'api.news.delete',
            'Status' => 'api.news.status',
            'Export' => 'api.news.download'
        ],
        'Divisions' => [
            'View' => 'divisions.index|api.divisions.index',
            'Status' => 'api.divisions.status',
            'Export' => 'api.divisions.download'
        ],
        'Services' => [
            'View' => 'services.index|api.services.index',
            'Status' => 'api.services.status',
            'Export' => 'api.services.download'
        ],
        'Account Type' => [
            'View' => 'account_type.index|api.account_type.index',
            'Add' => 'account_type.add|api.account_type.store',
            'Edit' => 'account_type.edit|api.account_type.edit|api.account_type.update',
            'Delete' => 'api.account_type.delete',
            'Status' => 'api.account_type.status',
            'Export' => 'api.account_type.download'
        ],
        'Bank' => [
            'View' => 'bank.index|api.bank.index',
            'Add' => 'bank.add|api.bank.store',
            'Edit' => 'bank.edit|api.bank.edit|api.bank.update',
            'Delete' => 'api.bank.delete',
            'Status' => 'api.bank.status',
            'Export' => 'api.bank.download'
        ],
        'Bank Account Type' => [
            'View' => 'bank_type.index|api.bank_type.index',
            'Add' => 'bank_type.add|api.bank_type.store',
            'Edit' => 'bank_type.edit|api.bank_type.edit|api.bank_type.update',
            'Delete' => 'api.bank_type.delete',
            'Status' => 'api.bank_type.status',
            'Export' => 'api.bank_type.download'
        ],
        'Booking Type' => [
            'View' => 'booking_type.index|api.booking_type.index',
            'Add' => 'booking_type.add|api.booking_type.store',
            'Edit' => 'booking_type.edit|api.booking_type.edit|api.booking_type.update',
            'Delete' => 'api.booking_type.delete',
            'Status' => 'api.booking_type.status',
            'Export' => 'api.booking_type.download'
        ],
    ],
];
