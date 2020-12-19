<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Auth\Exceptions\InvalidCredentialsException;

class AuthController extends Controller
{
    public function login(Request $request, AuthServiceInterface $authService)
    {
        $data = $this->validate(
            $request,
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|string'
            ]
        );

        try {
            return response()->json(
                $authService->login($data)
            );
        } catch (InvalidCredentialsException $e) {
            // TODO return resource
            return response()->json(['message' => 'Invalid Credentials'], 422);
        } catch (\Exception $e) {
            $this->logger->error($e->getTraceAsString());

            return response()->json(
                ['message' => 'Server error. Try again later'],
                500
            );
        }
    }
}
