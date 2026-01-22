<?php

namespace App\Helpers;

class FormatUtil
{
    /**
     * Format angka ke format pendek (Ribuan, Jutaan, Miliar)
     * Contoh: 1.500.000 -> 1.5Jt
     */
    public static function formatMoneyShort($amount)
    {
        if ($amount >= 1000000000) return 'Rp ' . round($amount / 1000000000, 1) . 'M';
        if ($amount >= 1000000) return 'Rp ' . round($amount / 1000000, 1) . 'Jt';
        if ($amount >= 1000) return 'Rp ' . round($amount / 1000, 1) . 'Rb';
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
