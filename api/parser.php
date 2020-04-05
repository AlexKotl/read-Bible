<?php
# Bible parser

$api_url = "https://api.bibleonline.ru";

$data = file_get_contents($api_url . "/booklist");
// fixing one bug in the API
if ($data[0] === '(') {
    $data = substr($data, 1);
    $data = substr($data, 0, strlen($data)-2);
}
$books = json_decode($data, true);
if (!is_array($books)) {
    die("Can't parse books list. Json error: " . json_last_error() . "\n\n{$data}");
}

foreach ($books as $book) {
    if (isset($book['li'])) {
        $book_name = $book['li']['Name'];
        echo "\n\nParsing {$book_name}";

        die('Finished one book');
    }
}

echo "\n\nParsing complete.";