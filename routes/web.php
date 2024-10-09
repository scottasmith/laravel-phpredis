<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/not-working', function () {
    $redis = new \Redis(['host' => 'redis', 'port' => 6379]);
    $redis->zAdd('laravel:tag:testA', -1, 'value');
    $cursor='0';

    return var_export($redis->zScan('laravel:tag:testA', $cursor, '*', 10), true);
});

Route::get('/working', function () {
    $redis = new \Redis(['host' => 'redis', 'port' => 6379]);
    $redis->zAdd('laravel:tag:testB', -1, 'value');
    $cursor=null;

    return var_export($redis->zScan('laravel:tag:testB', $cursor, '*', 10), true);
});

Route::get('/laravel-failing', function () {
    Cache::tags(['some-tag'])->set('testC', 'abc123');

    $responses = [
        'before' => var_export(Cache::tags(['some-tag'])->get('testC'), true),
    ];

    Cache::tags(['some-tag'])->flush();

    $responses['after'] = var_export(Cache::tags(['some-tag'])->get('testC'), true);

    return response()->json($responses);
});
