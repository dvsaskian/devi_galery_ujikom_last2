<?php
function timeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    
    $seconds = $time_difference;
    $minutes = round($seconds / 60);      
    $hours = round($seconds / 3600);      
    $days = round($seconds / 86400);     

    if ($days == 0) {
        if ($minutes < 60) {
            return "$minutes minutes ago";
        } else {
            return "$hours hours ago";
        }
    } else {
        return date('Y-m-d', $time_ago);  
    }
}
?>
