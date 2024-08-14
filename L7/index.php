<?php

$arr = ["Salam", "SaS", "Hello", "SoS","121"];
$count = 0;

for ($i = 0; $i < count($arr); $i++) {
    if (isPalindrome(strtolower($arr[$i]))) {
        $count++;
    }
}

echo "Palindrome count: " . $count;

function strrev_for($str) {
    $reversed = '';
    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        $reversed .= $str[$i];
    }
    return $reversed;
}

function isPalindrome($str) {
    if (strrev_for($str) == $str) {
        return true;
    } else {
        return false;
    }
}
