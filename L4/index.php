<?php


// 1dən 20e kimi ededelerin cemini tapın, 


function findSum(){
    $sum=0;
    for($i=1;$i<=20;$i++){
        $sum+=$i;
        
    }
    echo "1dən 20e kimi ededelerin cemi  :" . $sum ."<br>";
}
findSum();
// 1den 20e kimi 4ə bölünən ədədlərin sayını tapın(diqqet:say)

function  findCount(){
    $count=0;
    for($i=1;$i<=20;$i++){
        if($i%4==0){
            $count++;
        }
    }
    echo "1den 20-e kimi 4-e bolunen eded sayi: " . $count . "<br>";
}
findCount();
// Verilən stringin Palindrom  olub olmadığını tapan bir funksiya yazın ( for ilə )
function isPalindrome($str){
    $pal=false;
    $str = strtolower($str);
    
    
    $len = strlen($str);
    
    for ($i = 0; $i < $len / 2; $i++) {
        if ($str[$i] != $str[$len - $i - 1]) {
           $pal=true;
        }else{
            $pal=false;
        }
    }
    
  if($pal){
    echo "Palindromdur" . "<br>";
  }else{
    echo "Palindrom deyil" . "<br>";
  }
}
isPalindrome("Hello");
//  Verilən mətindəki saitlərin sayını hesablayan bir funksiya yazın
function countVowels($str) {
    $str = strtolower($str);
    
    $vowels = ['a', 'e', 'i', 'o', 'u',"ı","ö","ü"];
    
    $count = 0;
    
    for ($i = 0; $i < strlen($str); $i++) {
        if (in_array($str[$i], $vowels)) {
            $count++;
        }
    }
    
    return "Sozde saitlerin cemi ".$count ;
}

echo countVowels("Hello World!"); 
//  Verilən ədədin rəqəmlərinin toplamını hesablayan kod (məs : 123 => 6)
function sumOfDigits($num) {
    $sum = 0;
    
    while ($num > 0) {
        $sum += $num % 10;
        $num = floor($num / 10);
    }
    
    return "<br>"." Daxil ededin reqemleri cemi:" . $sum;
}

echo sumOfDigits(123);