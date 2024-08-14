 <?php
 
// 1.verilən hərf sözün daxilində işlənibsə ekrana herflerin sayi çıxsın
function countWord($word,$letter){
    $count=substr_count($word,$letter);
    echo "Sozde daxil edilen herfin sayi :".$count ."<br>";
}
$word="Tahira";
$letter="a";
countWord($word,$letter);
// 2.verilən hərf sözün daxilində işlənibsə ekrana bəli əks halda xeyr çıxsın
function isLetterInWord($word,$letter)
{
    if(strpos($word,$letter)){
    return "Beli";
    }else{
        return "Xeyr";
    }
}
$word="Tahira";
$letter="a";
echo "Sozde daxil edilen her var mi?  ". isLetterInWord($word,$letter) ."<br>";

// 3.array yalnız cüt ədədlərdən ibarət olmalıdır, əgər şərt ödənmirsə yəni tək ədədə rast gəlirsizsə ekrana xeyr yazılsın əks halda bəli
function onlyEven($array){
    for($i=0;$i<count($array);$i++){
        if($array[$i]%2!=0){
            return "xeyr";
            break;
        }
        echo "bəli";
        }
}
$arr=[1,2,3,4,5];
echo "Arrayda yalniz cut ededler var  ?  ".onlyEven($arr)."<br>";
// 4)arrayin icindeki elementleri 2 vahid artiraraq cap et meselen:
// [1,2,3,4,5] bu arrayi yeni belə arraya çevir [3,4,5,6,7]
function addTwoToEach($array) {
    for ($i = 0; $i < count($array); $i++) {
        $array[$i] = $array[$i] + 2;
    }
    return $array;
}

$array = [1, 2, 3, 4, 5];
$new_array = addTwoToEach($array);
print_r($new_array);
// 5)arrayin en boyuk elementi olmadan elementlerinin cemini tap
// [1,2,3,4,5] 1+2+3+4-un cemi yeni maximum element olmadan(hazır max funksiyasindan istifadə etmədən)
function sum_without_max($array) {
    if (count($array) == 0) {
        return 0;
    }
    $max_value = $array[0];
    $max_index = 0;

    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] > $max_value) {
            $max_value = $array[$i];
            $max_index = $i;
        }
    }

    unset($array[$max_index]);
    $sum = array_sum($array);
   return $sum;
}

$array = [1, 2, 3, 4, 5];
echo "<br>  Netice  ".sum_without_max($array);