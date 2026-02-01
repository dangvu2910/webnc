<?php

namespace App\Helpers;

class OrderHelper
{
    /**
     * Get Vietnamese label for order status
     */
    public static function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipped' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            'processing' => 'Đang xử lý',
            'paid' => 'Đã thanh toán',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    /**
     * Get badge color for order status
     */
    public static function getStatusBadgeColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'processing' => 'info',
            'paid' => 'success',
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Get badge class for Tailwind
     */
    public static function getStatusBadgeTailwind($status)
    {
        $classes = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100',
            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100',
            'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-100',
            'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100',
            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100',
            'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100',
        ];

        return $classes[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100';
    }
}
