<?php 
/**
 * Example of Tailwindo class.
 */
use Abdumu\Tailwindo\Converter;

require 'src/Converter.php';

$htmlFile = 'input/index.html';
$outputFolder = 'output';

$input = '<div class="container mt-3">
                <div class="alert alert-danger">
                    Hi! <a class="alert-link" href="#">click here</a> to continue...
                </div>
            </div>';

$output = (new Converter())
            ->setContent($input)
            ->convert()
            ->get();

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
  
  <style>
  
  </style>
</head>

<body>

    <?=$output?>
    
    <div class="container mx-auto">
    <br>
    <hr>
    <h4>from Bootstrap CSS</h4>
    <pre><?=nl2br(htmlspecialchars($input))?></pre>
    <br>
    <hr>
        <h4>to Tailwind CSS</h4>
    <pre><?=nl2br(htmlspecialchars($output))?></code>
    </div>
</body>
</html>

