<?php



// 1.$fruits = ['apple', 'banana', 'cherry'];
// əgər arrayda "apple" varsa "orange" da əlavə olunsun,yoxdursa olmasin.

$fruits = ['apple', 'banana', 'cherry'];

if (in_array('apple', $fruits)) {
    $fruits[] = 'orange';
}

print_r($fruits);
echo "<br>";
// 2.$firstArray = [1, 2, 3];
// $secondArray = [4, 5, 6]; ikinci arraydaki elementleri birinciye köçürün (2üsulla:həm hazir funksiya ile hem forla)
$firstArray = [1, 2, 3];
$secondArray = [4, 5, 6];

$mergedArray = array_merge($firstArray, $secondArray);

print_r($mergedArray);

echo "<br>";
// -----------------------------------------------------------------
foreach ($secondArray as $element) {
    $firstArray[] = $element;
}

print_r($firstArray);



echo "<br>";



// 3.$numbers = [1, 2, 3, 4, 5]; arrayin sonuncu elementini silin,ekrana həm yeni vəziyyətdə olan arrayi çıxardın(yəni $numbers = [1, 2, 3, 4],həm də silinmiş elementi(bu formada: "arraydan silinmiş element:5")


$numbers = [1, 2, 3, 4, 5];
$deletedElement = array_pop($numbers);

echo "Sildikden sonra array: ";
print_r($numbers);
echo "Arraydan silinmiş element: $deletedElement";





echo "<br>";



// 4.$stack = ['a', 'b', 'c', 'd', 'e']; arrayin bütün elementlərini silin,boş arrayi print edin ve her dövrdə silinen elementleri ekrana çıxarın ("arraydan silinmiş element:e";"arraydan silinmiş element:d  və s."


$stack = ['a', 'b', 'c', 'd', 'e'];

foreach ($stack as $element) {
    array_pop($stack);
    echo "Arrayden silinmis element: $element<br>";
}

echo "boş array: ";
print_r($stack);
echo "<br>";


// 5.arrayden son 3 element silinsin,(istenilen sayda elementi olan arraydan),$numbers = [1, 2, 3, 4, 5]
$numbers = [1, 2, 3, 4, 5];
array_splice($numbers, -3);

print_r($numbers);

echo "<br>";

// 6.$person = [
//     'name' => 'John',
//     'age' => 30,
//     'city' => 'New York',
// ]; arrayda "age" keyi varsa "Johnun (x) yaşı var" ekrana çıxsın"(adı və yaşını manual özünüz əllə yazmayin,arrayin elementine çatılma qaydasi necədirsə o şəkildə)
$person = [
    'name' => 'John',
    'age' => 30,
    'city' => 'New York',
];

if (array_key_exists('age', $person)) {
    echo "{$person['name']}un ({$person['age']}) yaşı var";
}

echo "<br>";


// 7.$users = [
//     ['id' => 1, 'name' => 'John', 'age' => 30],
//     ['id' => 2, 'name' => 'Jane', 'age' => 25],
//     ['id' => 3, 'name' => 'Doe', 'age' => 35],
// ];
// butun userlerin ad ve yaslari cumle şəklində ekrana cixsin(johnun 30 yasi var ve s.)


$users = [
    ['id' => 1, 'name' => 'John', 'age' => 30],
    ['id' => 2, 'name' => 'Jane', 'age' => 25],
    ['id' => 3, 'name' => 'Doe', 'age' => 35],
];

foreach ($users as $user) {
    echo "{$user['name']}un {$user['age']} yaşları var ve s. ";
}

echo "<br>";




// 8.$student = [
//     'name' => 'Alice',
//     'grades' => [
//         'math' => 85,
//         'science' => 90,
//         'history' => 80,
//     ],
// ];
// telebenin her fen uzre ballarini ekrana cixarin "riyaziyyat fenninden 85" ve s.

$student = [
    'name' => 'Alice',
    'grades' => [
        'math' => 85,
        'science' => 90,
        'history' => 80,
    ],
];

foreach ($student['grades'] as $subject => $grade) {
    echo "{$subject} fennindən $grade ve s. ";
}
echo "<br>";

// 9.hem array_map()-le hem de array walkla arrayin her elementinin üstüne 2 gelin, $array = [1, 2, 3, 4, 5];



$array = [1, 2, 3, 4, 5];

$mappedArray = array_map(function($item) {
    return $item + 2;
}, $array);

print_r($mappedArray);

array_walk($array, function(&$item) {
    $item += 2;
});

print_r($array);

echo "<br>";





// 10.array maple adlari Uppercase edin $names = ['alice', 'bob', 'charlie'];
$names = ['alice', 'bob', 'charlie'];

$uppercasedNames = array_map('strtoupper', $names);

print_r($uppercasedNames);


echo "<br>";




// 11.array mapla iki arrayi cemleyin her elementini bir biri ile cemleyin $array1 = [1, 2, 3, 4, 5];
// $array2 = [10, 20, 30, 40, 50]; (netice bu olmalidir:Array
// (
//     [0] => 11
//     [1] => 22
//     [2] => 33
//     [3] => 44
//     [4] => 55
// )

$array1 = [1, 2, 3, 4, 5];
$array2 = [10, 20, 30, 40, 50];

$resultArray = array_map(function($a, $b) {
    return $a + $b;
}, $array1, $array2);

print_r($resultArray);
echo "<br>";
// 12.array walkla her adin sonuna Smith soyadini elave edin $names = ['Alice', 'Bob', 'Charlie'];(netice:Array
// (
//     [0] => Alice Smith
//     [1] => Bob Smith
//     [2] => Charlie Smith
// )
$names = ['Alice', 'Bob', 'Charlie'];

array_walk($names, function(&$name) {
    $name .= ' Smith';
});

print_r($names);
echo "<br>";
// 13.$person = [
//     'name' => 'John',
//     'age' => 30,
// ];  array walkla ad ve yasi modifikasiya edin ve elementler bu sekilde deyissin,qarsilarina user_ yazilsin)(netice:Array
// (
//     [name] => user_John
//     [age] => user_30
// )
$person = [
    'name' => 'John',
    'age' => 30,
];

array_walk($person, function(&$value, $key) {
    $value = "user_$value";
});

print_r($person);
