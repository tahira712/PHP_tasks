<?php


// Her iki tapsiriqda arrayin elementlerine çatıb, ekrana vermək l lazimdir



// 1-ci tapsiriq.
$users = [
"name" => "Ayan",
"hobbies" => [
"football", "domino"
],
];

echo "Name:  ". $users["name"]. "<br>";
echo "Hobbies:  ". $users["hobbies"][0] ." , ". $users["hobbies"][1]. "<br>";

echo "<br>";
echo "<br>";
echo "<br>";

// 2-ci tapsiriq.
$blogs = [
[
'title' => 'How can i learn PHP',
'tags' => [
'php', 'learn', 'it', 'programming'
],
'creator' => [
'name' => 'Janna',
'surname' => 'Smith'
],
'views' => [
[
'user' => 'Tom',
'ip' => '192.168.1.1'
],
[
'user' => 'Bob',
'ip' => '192.168.1.2'
],
[
'user' => 'Jon',
'ip' => '192.168.1.3'
],
],
],
[
'title' => 'How can i learn JS',
'tags' => [
'js', 'learn', 'it', 'programming', 'frontend', 'backend'
],
'creator' => [
'name' => 'Huseyn',
'surname' => 'Kerimov'
],
'views' => [
[
'user' => 'Selim',
'ip' => '192.168.1.1'
],
[
'user' => 'Bob',
'ip' => '192.168.1.2'
],
[
'user' => 'Jon',
'ip' => '192.168.1.3'
],
[
'user' => 'Elesger',
'ip' => '192.168.1.4'
],
[
'user' => 'Elovset',
'ip' => '192.168.1.5'
],
],

],

];

foreach($blogs as $blog){

echo "Title:  ". $blog["title"]. "<br>";
echo "Tags:  ". $blog["tags"][0] ." , ". $blog["tags"][1]. "<br>";
echo "Creator:  ". $blog["creator"]["name"] ." ---------"."user's ip:  ". $blog["creator"]["surname"]. "<br>";
echo "Views:  ". $blog["views"][0]["user"] ."--------" ."user's ip:  ". $blog["views"][0]["ip"]. "<br>";
}