<?php

namespace GeekDC\Sensitive\Middleware;

use Sensitive;

use Closure;

class SensitiveFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->all();

        $data = array_where($data, function ($value) {
            return Sensitive::match($value);
        });

        if (count($data)) {
            throw new \Exception(config('sensitive.error_message'));
        }

        return $next($request);
    }
}
