<?php

// 1.çevrənin sahəsini hesablayan funksiya yazın(radius parametr olsun)
function circleArea($radius) {
    return pi() * $radius ** 2;
}
$area = circleArea(5);
echo "Sahə: " . number_format($area ,2). "<br>";

// 2.adamin adi və soyadini yazdiqda onlari fullname kimi birlikdə göstərən funksiya yazin(Soyadini yazmasa error cixmasin,təkcə adini yazibsa Adi cixsin ekrana)
function fullName($firstName, $lastName = '') {
    if ($lastName === '') {
        return $firstName;
    }
    return $firstName . ' ' . $lastName;
}
$first = fullName("Tahira");
$full = fullName("Tahira", "Huseynova");
echo "Adı: " . $first . "<br>";
echo "Adı və Soyadı: " . $full . "<br>";

// 3.iki ededi birbirine bolun(sifira bolme etse ekrana sifira bolmek  olmaz erroru cixsin) (funksiya formasinda)
function divide($a, $b) {
    if ($b == 0) {
        return "Sıfıra bölmək olmaz";
    }
    return $a / $b;
}
echo "Bolmenin neticesi: " . divide(10, 2) . "<br>";
echo "Bolmenin neticesi: " . divide(10, 0) . "<br>";

// 4.3 ededden en boyuyunu ekrana cixaran funksiya yaradin
function maxOfThree($a, $b, $c) {

    if ($a > $b && $a > $c) {
        return $a;
    }elseif($b > $a && $b > $c){
        return $b;
    }elseif($c > $a && $c > $b){
        return $c;
    }else{
        return "Beraberdirler";
    }
}
echo "Ən böyük ədəd: " . maxOfThree(1,2,3) . "<br>";

// 5.2 ededden kicik olani ekrana cixaran funksiya yaradin
function minOfTwo($a, $b) {
    if ($a > $b) {
        return $b;
    }else{
        return $a;
    }
}
echo "Ən kiçik ədəd: " . minOfTwo(1, 2) . "<br>";

// 6.sozun uzunlugu 6dan uzun olduqda ekrana "6dan cox simvol daxil etmek olmaz"erroru cixardan funksiya yazin
function checkStringLength($str) {
    if (strlen($str) > 6) {
        return "6-dan çox simvol daxil etmək olmaz";
    }
    return $str;
}
echo "Netice: " . checkStringLength("hello") . "<br>";
echo "Netice:" . checkStringLength("hello world") . "<br>";

?>
