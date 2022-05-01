<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('car_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('中古トラック一覧', route('car.index'));
});
Breadcrumbs::for('car_detail', function (BreadcrumbTrail $trail, $car) {
    $trail->parent('car_list');
    $trail->push($car->name, route('car.show', $car->id));
});
Breadcrumbs::for('car_manager_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('出品車両一覧', route('car_manager.index'));
});
Breadcrumbs::for('car_manager_detail', function (BreadcrumbTrail $trail, $car) {
    $trail->parent('car_manager_list');
    $trail->push($car->name, route('car_manager.show', $car->id));
});
Breadcrumbs::for('car_manager_create', function (BreadcrumbTrail $trail) {
    $trail->parent('car_manager_list');
    $trail->push('管理車両追加', route('car_manager.create'));
});
Breadcrumbs::for('car_manager_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('car_manager_list');
    $trail->push('管理車両編集', route('car_manager.create'));
});
Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('ログイン', route('login'));
});
Breadcrumbs::for('reset_password', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('パスワードを忘れた方', route('password.request'));
});
Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('コラム一覧', route('blog.index'));
});
Breadcrumbs::for('blog_detail', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('blog');
    $trail->push($post->title, route('blog.show', $post->id));
});
Breadcrumbs::for('banner', function (BreadcrumbTrail $trail, $banner) {
    $trail->parent('home');
    $trail->push($banner->title, route('banner.show', $banner->id));
});
Breadcrumbs::for('account', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('会員情報', route('account.index'));
});
Breadcrumbs::for('terms_of_service', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('利用規約');
});
Breadcrumbs::for('label_convention', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('特定商取引法に基づく表記');
});
Breadcrumbs::for('privacy_policy', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('プライバシーポリシー');
});
Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('運営会社情報');
});
Breadcrumbs::for('search_history', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('検索した保存条件', route('search_history.index'));
});
Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $title) {
    $trail->parent('home');
    $trail->push($title);
});
Breadcrumbs::for('order.buy_detail', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('在庫確認・商談申込詳細');
});
