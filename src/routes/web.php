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
     *         response=200,
     *         description="Access token and refresh token"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input"
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
     *     summary="Get list of roles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of roles",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Role")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    $router->get('/', ['uses' => 'RolesController@list', 'middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW]);

    $router->group(['middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW], function () use ($router) {
        /**
         * @OA\Get(
         *     path="/roles/{roleId}",
         *     tags={"Roles"},
         *     summary="Get role",
         *     security={{"bearerAuth":{}}},
         *     @OA\Parameter(
         *         name="roleId",
         *         in="path",
         *         required=true,
         *         description="Role ID"
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Role",
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="data",
         *                 type="object",
         *                 ref="#/components/schemas/Role"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not found"
         *     )
         * )
         */
        $router->get(
            '/{roleId}',
            ['uses' => 'RolesController@show', 'middleware' => 'authorize:' . PermissionEnum::ROLES_VIEW]
        );

        /**
         * @OA\Post(
         *     path="/roles",
         *     tags={"Roles"},
         *     summary="Create role",
         *     security={{"bearerAuth":{}}},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="name",
         *                 type="string"
         *             ),
         *             @OA\Property(
         *                 property="slug",
         *                 type="string"
         *             ),
         *             @OA\Property(
         *                 property="is_active",
         *                 type="boolean"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Role",
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="data",
         *                 type="object",
         *                 ref="#/components/schemas/Role"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Invalid input"
         *     )
         * )
         */
        $router->post(
            '/',
            ['uses' => 'RolesController@create', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );

        /**
         * @OA\Put(
         *     path="/roles/{roleId}",
         *     tags={"Roles"},
         *     summary="Update role",
         *     security={{"bearerAuth":{}}},
         *     @OA\Parameter(
         *         name="roleId",
         *         in="path",
         *         required=true,
         *         description="Role ID"
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="name",
         *                 type="string"
         *             ),
         *             @OA\Property(
         *                 property="slug",
         *                 type="string"
         *             ),
         *             @OA\Property(
         *                 property="is_active",
         *                 type="boolean"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Role",
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="data",
         *                 type="object",
         *                 ref="#/components/schemas/Role"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Invalid input"
         *     )
         * )
         */
        $router->put(
            '/{roleId}',
            ['uses' => 'RolesController@update', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );

        /**
         * @OA\Delete(
         *     path="/roles/{roleId}",
         *     tags={"Roles"},
         *     summary="Delete role",
         *     security={{"bearerAuth":{}}},
         *     @OA\Parameter(
         *         name="roleId",
         *         in="path",
         *         required=true,
         *         description="Role ID"
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Role",
         *         @OA\JsonContent(
         *             @OA\Property(
         *                 property="message",
         *                 type="string"
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not found"
         *     )
         * )
         */
        $router->delete(
            '/{roleId}',
            ['uses' => 'RolesController@delete', 'middleware' => 'authorize:' . PermissionEnum::ROLES_MANAGE]
        );
    });
});
