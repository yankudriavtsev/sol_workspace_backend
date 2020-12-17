<?php

namespace App\Http\Middleware;

use Closure;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use App\Services\JWT\JwtServiceInterface;
use Firebase\JWT\SignatureInvalidException;

class Authenticate
{
    private JWTServiceInterface $jwtService;
    private LoggerInterface $logger;

    public function __construct(JwtServiceInterface $jwtService, LoggerInterface $logger)
    {
        $this->jwtService = $jwtService;
        $this->logger = $logger;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response('Unauthorized.', 401);
        }

        try {
            $jwtPayload = $this->jwtService->decode($token);
        } catch (ExpiredException $e) {
            return response('JWT token expired.', 401);
        } catch (UnexpectedValueException | SignatureInvalidException | BeforeValidException $e) {
            return response('Unauthorized.', 401);
        } catch (\Exception $e) {
            $this->logger->error($e->getTraceAsString());
            return response('Server error. Try again later', 500);
        }

        if ($jwtPayload->type !== JwtServiceInterface::TOKEN_TYPE_ACCESS) {
            return response('Invalid JWT token type.', 401);
        }

        $request->merge([
            'jwt_payload' => $jwtPayload
        ]);

        return $next($request);
    }
}
