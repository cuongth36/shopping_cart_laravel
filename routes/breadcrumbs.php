<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'));
});

Breadcrumbs::for('product.show', function ($trail) {
    $trail->parent('home');
    $trail->push('Danh mục', route('product.show'));
});

Breadcrumbs::for('product_category.show', function ($trail, $prod_cate) {
    $prod_cate = str_replace_last('.html', '', $prod_cate);
    $trail->parent('product.show', $prod_cate);
    $trail->push($prod_cate, route('product_category.show',[$prod_cate , '.html']));
});

//Product detail

Breadcrumbs::for('product.detail', function ($trail , $product) {
    $product = str_replace_last('.html', '', $product);
    $trail->parent('home');
    $trail->push($product, route('product.detail', [$product, '.html']));
});

//Page 

Breadcrumbs::for('page.detail', function ($trail , $page) {
    $page = str_replace_last('.html', '', $page);
    $trail->parent('home');
    $trail->push($page, route('page.detail', [$page, '.html']));
});

//Post
Breadcrumbs::for('post.show.list', function ($trail) {
    $trail->parent('home');
    $trail->push('Tin tức', route('post.show.list'));
});

//Post detail
Breadcrumbs::for('post.detail', function ($trail , $post) {
    $post = str_replace_last('.html', '', $post);
    $trail->parent('post.show.list', $post);
    $trail->push($post, route('post.detail', [$post, '.html']));
});
?>