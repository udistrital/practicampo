<?php

namespace Tests\Unit;

use Tests\TestCase;

class HeadersTest extends TestCase
{
    public function testSecurityHeaders()
    {
        $response = $this->get('/');
    
        $response->assertHeader('Content-Security-Policy', "default-src 'self'");
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
    }
}
