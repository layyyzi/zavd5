<?php

// 1. Перевірити, чи була натиснута кнопка "submit" на формі
if(!isset($_POST["submit"])){
    header("Location: index.php");
}

// 2. Отримаємо ім'я файлу, який користувач вибрав для завантаження
if(!isset($_FILES["fileToUpload"])){
    echo "Файл не был отправлен.";
    exit;
}
$fileName = $_FILES["fileToUpload"]["name"];
$fileSize = $_FILES["fileToUpload"]["size"];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$fileExtensions = ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif'];

// 3. Перевірити, чи файл вже існує в папці "uploads"
if(file_exists("uploads/". $fileName)){
    echo "Файл з ім'ям $fileName вже існує.";
}
// 4. Перевірити чи це текстовий файл
elseif(!in_array($fileExtension, $fileExtensions)){
    echo "Цей тип файлу не підтримується.";
}
// 5. Перевірити розмір файлу
elseif($fileSize > 10000000){
    echo "Файл занадто великий. Максимальний розмір файлу - 10MB.";
}
// Все ОК, завантажуємо файл
// Все ОК, завантажуємо файл
else{
    $newFileName = $_POST["fileName"]. "_". date("Y-m-d_H-i-s"). ".". $fileExtension;
    if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])){
        $uploadDir = "uploads/images/";
    } else {
        $uploadDir = "uploads/docs/";
    }
    if(!file_exists($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadDir. $newFileName)){
        echo "Файл $newFileName успішно завантажено.";
    } else {
        echo "Помилка при переміщенні файлу.";
    }
}

// Виведіть список файлів, які знаходяться в папці uploads та підпапках /images та /docs
$files = scandir("uploads");
echo "<h2>Файли в папці uploads:</h2><ul>";
foreach($files as $file){
    if($file!= "." && $file!= ".."){
        echo "<li>$file</li>";
    }
}
echo "</ul>";

$images = scandir("uploads/images");
echo "<h2>Файли в папці images:</h2><ul>";
foreach($images as $image){
    if($image!= "." && $image!= ".."){
        echo "<li>$image</li>";
    }
}
echo "</ul>";

$docs = scandir("uploads/docs");
echo "<h2>Файли в папці docs:</h2><ul>";
foreach($docs as $doc){
    if($doc!= "." && $doc!= ".."){
        echo "<li>$doc</li>";
    }
}
echo "</ul>";

?>
<p>
    <a href="index.php">Go home</a>
</p>
