<?php
use App\User;
use App\Seller;
use App\Product;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'               => $faker->name,
        'email'              => $faker->unique()->safeEmail,
        'password'           => $password ?: $password = bcrypt('secret'),
        'remember_token'     => str_random(10),
        'verified'           => $verified = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin'              => $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER])
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity'    => $faker->numberBetween(1, 10),
        'status'      => $faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
        'image'       => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg',]),
        'seller_id'   => User::all()->random()->id,
        //User::inRandomOrder()->first()->id
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {

    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();

    return [
        'quantity'   => $faker->numberBetween(1, 3),
        'buyer_id'   => $buyer->id,
        'product_id' => $seller->products->random()->id
    ];
});
