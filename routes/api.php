<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::patch('campaigns/apply/{order_id}', [CampaignController::class, 'applyCampaign']);
