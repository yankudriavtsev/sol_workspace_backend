<?php

namespace App\Http\Controllers;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/roles",
     *     tags={"Roles"},
     *     summary="List of roles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of roles"
     *     )
     * )
     */
    public function list()
    {
        var_dump(request()->jwt_payload);exit;
    }
}
