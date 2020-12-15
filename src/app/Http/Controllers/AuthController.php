<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Auth\Exceptions\InvalidCredentialsException;

class AuthController extends Controller
{
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
     *         description="Invalid input", @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Access token and refresh token", @OA\JsonContent()
     *     )
     * )
     */
    public function login(Request $request, AuthServiceInterface $authService)
    {
        $data = $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string'
        ]);

        try {
            return response()->json($authService->login($data['email'], $data['password']));
        } catch (InvalidCredentialsException $e) {
            return response()->json(['message' => 'Invalid Credentials'], 422);
        } catch (\Exception $e) {
            $this->logger->error($e->getTraceAsString());
            return response()->json(['message' => 'Server error. Try again later'], 500);
        }
    }
}
