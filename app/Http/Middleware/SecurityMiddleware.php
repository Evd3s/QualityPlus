<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SecurityMiddleware
{
    protected $suspiciousUserAgents = [
        'curl',
        'wget',
        'python',
        'bot',
        'crawler',
        'spider',
        'scraper',
        'postman',
        'insomnia'
    ];
    
    protected $allowedUserAgents = [
        'googlebot',
        'bingbot',
        'facebookexternalhit'
    ];

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $userAgent = strtolower($request->userAgent() ?? '');
        
        
        if (Cache::has("blocked_ip:{$ip}")) {
            Log::warning("Blocked IP attempted access: {$ip}");
            abort(429, 'Too Many Requests');
        }
        
        
        if ($this->isSuspiciousUserAgent($userAgent) && !$this->isAllowedUserAgent($userAgent)) {
            $this->incrementSuspiciousActivity($ip);
            Log::warning("Suspicious User Agent: {$userAgent} from IP: {$ip}");
        }
        
        
        $key = "requests:{$ip}";
        $requests = Cache::get($key, 0);
        
        if ($requests >= 100) { 
            Cache::put("blocked_ip:{$ip}", true, 300); 
            Log::warning("IP blocked for exceeding rate limit: {$ip}");
            abort(429, 'Too Many Requests');
        }
        
        Cache::put($key, $requests + 1, 60); 
        
        
        if ($this->detectBotBehavior($request)) {
            $this->incrementSuspiciousActivity($ip);
        }
        
        return $next($request);
    }
    
    private function isSuspiciousUserAgent($userAgent)
    {
        foreach ($this->suspiciousUserAgents as $suspicious) {
            if (strpos($userAgent, $suspicious) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function isAllowedUserAgent($userAgent)
    {
        foreach ($this->allowedUserAgents as $allowed) {
            if (strpos($userAgent, $allowed) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function detectBotBehavior(Request $request)
    {
        
        $commonHeaders = ['accept-language', 'accept-encoding', 'connection'];
        $missingHeaders = 0;
        
        foreach ($commonHeaders as $header) {
            if (!$request->hasHeader($header)) {
                $missingHeaders++;
            }
        }
        
        
        if ($missingHeaders >= 2) {
            return true;
        }
        
        
        $ip = $request->ip();
        $lastRequest = Cache::get("last_request:{$ip}");
        $currentTime = time();
        
        if ($lastRequest && ($currentTime - $lastRequest) < 1) {
            Cache::put("last_request:{$ip}", $currentTime, 60);
            return true;
        }
        
        Cache::put("last_request:{$ip}", $currentTime, 60);
        return false;
    }
    
    private function incrementSuspiciousActivity($ip)
    {
        $key = "suspicious:{$ip}";
        $count = Cache::get($key, 0) + 1;
        
        if ($count >= 5) { 
            Cache::put("blocked_ip:{$ip}", true, 3600); 
            Log::warning("IP blocked for suspicious activity: {$ip}");
        } else {
            Cache::put($key, $count, 3600); 
        }
    }
}
