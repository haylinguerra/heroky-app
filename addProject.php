<?php
require_once 'vendor\autoload.php';


use Illuminate\Database\Capsule\Manager as Capsule;
use app\Models\Project;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'php-class',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

if (!empty($_POST)){
    $project = new Project();
    $project->title = $_POST['title'];
    $project->description = $_POST['description'];
    $project->link = $_POST['link'];
    $project->save();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
    crossorigin="anonymous">
</head>
<body>
<h1>Add a new Project</h1>
    <form action="addProject.php" method="post">
        <label for="title">Project title</label>
        <input type="text" name="title" id="title"><br>
        <label for="description">Description</label>
        <input type="text" name="description" id="description"><br>
        <label for="description">Link</label>
        <input type="text" name="link" id="link"><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>