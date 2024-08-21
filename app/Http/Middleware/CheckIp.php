<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Danh sách các dải IP được phép
        $allowedIps = [
            '192.168.1.1/24',
            '192.168.2.1/24',
            '192.168.3.1/24',
        ];

        // Lấy địa chỉ IP của người dùng
        $clientIp = $request->ip();

        // Kiểm tra IP có nằm trong dải IP cho phép không
        $accessGranted = false;
        foreach ($allowedIps as $allowedIp) {
            if ($this->ipInRange($clientIp, $allowedIp)) {
                $accessGranted = true;
                break;
            }
        }

        // Nếu IP không được phép, từ chối truy cập
        if (!$accessGranted) {
            // Tạo thông tin mạng cho phép và IP client để in ra
            $responseMessage = "Access denied\n";
            $responseMessage .= "Allowed Networks: " . implode(', ', $allowedIps) . "\n";
            $responseMessage .= "Your IP: " . $clientIp . "\n";

            // Trả về response với thông tin mạng và IP client
            // return response($responseMessage, 403)
            //     ->header('Content-Type', 'text/plain');

            // return redirect()->route('message.ipAccessDenied.blade');
            return response()->view('message.ipAccessDenied', ['responseMessage' => $responseMessage]);

        }

        return $next($request);
    }

    private function ipInRange($ip, $range)
    {
        list($rangeIp, $netmask) = explode('/', $range);
        $ipDecimal = ip2long($ip);
        $rangeDecimal = ip2long($rangeIp);
        $netmaskDecimal = ~((1 << (32 - $netmask)) - 1);

        return ($ipDecimal & $netmaskDecimal) == ($rangeDecimal & $netmaskDecimal);
    }
}
