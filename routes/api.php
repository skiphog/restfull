<?php

Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
