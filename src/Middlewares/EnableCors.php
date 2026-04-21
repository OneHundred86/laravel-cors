<?php

namespace Oh86\LaravelCors\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EnableCors
{
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->config = config('cors');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->shouldRun($request)) {
            return $next($request);
        }

        if ($request->method() == 'OPTIONS') {
            return response('', 204)->withHeaders([
                // 预检请求跨域响应头
                'Access-Control-Allow-Origin' => $request->header('Origin'),
                'Access-Control-Allow-Methods' => $request->header('Access-Control-Request-Method'),
                'Access-Control-Allow-Credentials' => $this->config['allowed_credentials'] ? 'true' : 'false',
                'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
                'Access-Control-Max-Age' => $this->config['max_age'],
            ]);
        } else {
            /** @var Response */
            $response = $next($request);

            return $response->withHeaders([
                'Access-Control-Allow-Origin' => $request->header('Origin'),
                'Access-Control-Allow-Credentials' => $this->config['allowed_credentials'] ? 'true' : 'false',
            ]);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function shouldRun($request)
    {
        $origin = $request->header('origin');
        // \Log::debug(__METHOD__, [
        //     'uri' => $request->getRequestUri(),
        //     'origin' => $origin,
        //     'referer' => $request->header('referer'),
        // ]);

        // 跨域
        if ($origin) {
            if (in_array($origin, $this->config['allowed_origins'])) {
                return true;
            }
        }

        return false;
    }
}
