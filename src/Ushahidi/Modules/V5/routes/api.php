<?php
/**
 * API version number
 */
$apiVersion = '5';
$apiBase = '/v' . $apiVersion;

$router->group([
    'prefix' => $apiBase,
], function () use ($router) {
    // Forms
    $router->group([
        // 'namespace' => 'Forms',
        'prefix' => 'surveys',
        'middleware' => ['scope:forms', 'expiration']
    ], function () use ($router) {
        // Public access
        $router->get('/', 'SurveyController@index');
        $router->get('/{id}', 'SurveyController@show');
    });

    $router->group([
        'prefix' => 'categories',
        'middleware' => ['scope:tags', 'expiration']
    ], function () use ($router) {
        // Public access
        $router->get('/', 'CategoryController@index');
        $router->get('/{id}', 'CategoryController@show');
    });

    // Restricted access
    $router->group([
        'prefix' => 'categories',
        'middleware' => ['auth:api', 'scope:tags']
    ], function () use ($router) {
        $router->post('/', 'CategoryController@store');
        $router->put('/{id}', 'CategoryController@update');
        $router->delete('/{id}', 'CategoryController@delete');
    });

    // Restricted access
    $router->group([
        'prefix' => 'surveys',
        'middleware' => ['auth:api', 'scope:forms']
    ], function () use ($router) {
        $router->post('/', 'SurveyController@store');
        $router->put('/{id}', 'SurveyController@update');
        $router->delete('/{id}', 'SurveyController@delete');
    });

    // Restricted access
    $router->group([
        'prefix' => '',
    ], function () use ($router) {
        $router->get('/languages', 'LanguagesController@index');
    });

    // Posts
    $router->group([
        'prefix' => 'posts',
        'middleware' => ['scope:posts', 'expiration']
    ], function () use ($router) {
        // Public access
        $router->get('/', 'PostController@index');
        $router->get('/{id}', 'PostController@show');
    });

    // Restricted access
    $router->group([
        'prefix' => 'posts',
        'middleware' => ['auth:api', 'scope:posts']
    ], function () use ($router) {
        $router->post('/bulk', 'PostController@bulkOperation');
        $router->put('/{id}', 'PostController@update');
        $router->patch('/{id}', 'PostController@patch');
        $router->delete('/{id}', 'PostController@delete');
    });

    $router->group([
        'prefix' => 'posts',
        'middleware' => ['scope:posts']
    ], function () use ($router) {
        // Public access
        $router->post('/', 'PostController@store');
        // temporary endpoints, these should eventually go away
        $router->post('/_ussd', 'USSDController@store');
        $router->post('/_whatsapp', 'WhatsAppController@store');
    });

     /* Roles */
    // Public access
    $router->group([
        'prefix' => 'roles',
        'middleware' => ['scope:roles', 'expiration']
    ], function () use ($router) {
        $router->get('/', 'RoleController@index');
        $router->get('/{id}', 'RoleController@show');
    });

    // Restricted access
    $router->group([
        'prefix' => 'roles',
        'middleware' => ['auth:api', 'scope:roles']
    ], function () use ($router) {
        $router->post('/', 'RoleController@store');
        $router->put('/{id}', 'RoleController@update');
        $router->delete('/{id}', 'RoleController@delete');
    // Restricted access
    $router->group([
        'prefix' => 'tos',
        'middleware' => ['auth:api', 'scope:tos']
    ], function () use ($router) {
        $router->get('/', 'TosController@index');
        $router->get('/{id}', 'TosController@show');
        $router->post('/', 'TosController@store');
    });
});
