<?php

return[
	'name' => "Laravel 学院",
    'title' => "Laravel test",
    'subtitle' => 'http://laravelacademy.org',
    'description' => 'Laravel学院致力于提供优质Laravel中文学习资源',
    'author' => '学院test',
    'page_image' => 'home-bg.jpg',
    'posts_per_page' => 10,
    'uploads' => [
        'storage' => 'public',
        'webpath' => '/storage',
    ],
    'rss_size' => 25,
    'contact_email'=>env('MAIL_FROM'),
];