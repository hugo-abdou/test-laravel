<?php

use App\Models\User;

$actions = [];
// add page to the array 
$sideBarLinks = [
    [
        ['name' => 'Home', 'icon' => 'feather icon-home', 'url' => route('home')],
        auth()->check() ? ['name' => 'Profile', 'icon' => 'feather icon-user', 'url' => route('profile', [auth()->user()->slug])] : false,
        ['name' => 'Trendin', 'icon' => 'feather icon-zap', 'url' => route('trendin')],
        ['name' => 'Subscriptions', 'icon' => 'feather icon-user-check', 'url' => route('subscriptions')]
    ],
    [
        [
            'name' => 'Your posts', 'icon' => 'feather  icon-file-text', 'sub_menu' => [
                ['name' => 'Add post', 'icon' => 'feather icon-file-plus', 'url' => route('post.create')],
                ['name' => 'Posts list', 'icon' => 'feather icon-file-text', 'url' => route('post.list')],
            ]
        ],
        ['name' => 'Liked post', 'icon' => 'feather icon-thumbs-up', 'url' => route('home')],
        auth()->check()  ? [
            'name' => 'Subscriptions', 'icon' => 'feather icon-user-check', 'sub_menu' =>
            User::with(['follow' => function ($q) {
                return $q->take(6);
            }])->findOrFail(auth()->id())->follow->map(function ($item) {
                return ['name' => $item->name, 'img' => url('storage/' . $item->profile_photo_path), 'url' => route('profile', [$item->slug])];
            }),
        ] : false,
    ],
    [
        ['name' => 'Settings', 'icon' => 'feather icon-settings', 'url' => route('home')],
        ['name' => 'Report', 'icon' => 'feather icon-clipboard', 'url' => route('home')],
        ['name' => 'Help', 'icon' => 'feather icon-info', 'url' => route('home')],
        ['name' => 'Feedback', 'icon' => 'feather icon-message-square', 'url' => route('home')]
    ],
];



// add action to the array 
if (!auth()->guest()) {
    $actions = [
        # section 1
        [
            [
                'name' => 'Your Profile',
                'url' => route('profile',  [auth()->user()->slug]),
                'icon' => 'feather icon-user',
            ],
            [
                'name' => 'Add Post',
                'url' => route('post.create'),
                'icon' => 'feather icon-plus-circle text-blue-500',
            ],
            [
                'name' => 'Settings',
                'url' => route('profile.edit'),
                'icon' => 'feather icon-settings',
            ],
        ],
        # section 2
        [['name' => 'Sing out', 'url' => route('logout'), 'method' => 'post', 'icon' => 'feather icon-power']],
    ];
}

return [
    'actions' => $actions,
    'side_bar' => $sideBarLinks
];
