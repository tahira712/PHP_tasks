<?php
// 1."menim adim Gulnar" ifadesinde "Gulnar"-ı "Gunel" sozu ile dəyişin
$sentence1 = "menim adim Gulnar";
$sentence1 = str_replace("Gulnar", "Gunel", $sentence1);
echo $sentence1 . "<br>" ;

// 2."Gulnar Bakida yasayir,Gulnar 3-cu kursda oxuyur." Burdakı ikinci Gülnarin neçənci yerdə olduğunu ekrana cixardin
$sentence2 = "Gulnar Bakida yasayir,Gulnar 3-cu kursda oxuyur.";
$firstOccurrence = strpos($sentence2, "Gulnar");
$secondOccurrence = strpos($sentence2, "Gulnar", $firstOccurrence + 1);
echo $secondOccurrence . "<br>";

// 3. sözün əvəzinə sözün uzunluğu qədər * (ulduz) ekrana çıxsın (əlavə olaraq str_repeat istifadə olunacaq)
$word = "söz";
$wordLength = strlen($word);
$stars = str_repeat("*", $wordLength);
echo $stars . "<br>";

// 4. kitab sözündəki k hərfini x ilə dəyişin
$word2 = "kitab";
$word2 = str_replace("k", "x", $word2);
echo $word2 . "<br>";

// 5. Caravan sözündən ravan hissəsini ekrana çıxarın
$word3 = "Caravan";
$ravan = substr($word3, 2, 5);
echo $ravan . "<br>";

// 6. Caravan sözündən rav hissəsini ekrana çıxarın
$rav = substr($word3, 2, 3);
echo $rav . "<br>";
?>
