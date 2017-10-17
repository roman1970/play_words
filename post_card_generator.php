<?php
require 'vendor/autoload.php';

//print_r($_POST); exit;
use Dompdf\Options;
use Dompdf\Dompdf;

$options = new Options();
$options->set('defaultFont', 'Courier');


if (@file_exists('user_doc.php') )
    $template = file_get_contents('user_doc.php');
else {
    echo 'upp';
    exit;
}

$signs = [
    'sender_from' => $_POST['sender_from'],
    'sender_to' => $_POST['sender_to'],
    'receiver_from' => $_POST['receiver_from'],
    'receiver_to' => $_POST['receiver_to'],
    ];

foreach ($signs as $key => $value)
    $template = str_replace('{' . $key . '}', $value, $template);


$dompdf = new Dompdf();
$dompdf->loadHtml($template);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
