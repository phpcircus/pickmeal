<?php

Route::group(['prefix' => 'api'], function ($router) {
    $router->post('pick', Meal\PickMeal::class)->middleware(['cors', 'throttle:2,1'])->name('pick');
    $router->post('location/autocomplete', Location\AutocompleteLocation::class)->middleware(['cors', 'throttle:15,1'])->name('location.autocomplete');
});
