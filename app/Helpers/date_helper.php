<?php

if (!function_exists('formatDateIndonesianFull')) {
    function formatDateIndonesianFull($date) {
        // Convert string date to DateTime object
        $dateObj = new DateTime($date);

        // Define Indonesian day and month names
        $days = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $months = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        // Format the date in Indonesian
        $day = $days[$dateObj->format('w')];
        $dateFormatted = $dateObj->format('d');
        $month = $months[(int)$dateObj->format('m')];
        $year = $dateObj->format('Y');

        return "$day, $dateFormatted $month $year";
    }
}

if (!function_exists('formatDateIndonesian')) {
    function formatDateIndonesian($date) {
        // Convert string date to DateTime object
        $dateObj = new DateTime($date);

        // Define Indonesian month names
        $months = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        // Format the date in Indonesian
        $dateFormatted = $dateObj->format('d');
        $month = $months[(int)$dateObj->format('m')];
        $year = $dateObj->format('Y');

        return "$dateFormatted $month $year";
    }
}

?>