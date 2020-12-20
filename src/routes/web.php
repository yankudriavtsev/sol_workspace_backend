<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Services\Permission\PermissionEnum;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="email",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Access token and refresh token"
     *     )
     * )
     */
    $router->post('/login', 'AuthController@login');
});

$router->group(['prefix' => 'roles', 'middleware' => 'authenticate'], function () use ($router) {
    /**
     * @OA\Get(
     *     path="/roles",
     *     tags={"Roles"},
     *     summary="List of roles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of roles",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Role")
     *             )
     *         ),
     *     )
     * )
     */
    $router->get('/', ['uses' => 'RolesController@list', 'middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW]);

    $router->group(['middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW], function () use ($router) {
        $router->get(
            '/{roleId}',
            ['uses' => 'RolesController@show', 'middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW]
        );

        $router->post(
            '/',
            ['uses' => 'RolesController@create', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );

        $router->put(
            '/{roleId}',
            ['uses' => 'RolesController@update', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );

        $router->delete(
            '/{roleId}',
            ['uses' => 'RolesController@delete', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );
    });
});
