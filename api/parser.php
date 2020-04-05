<?php
# Bible parser

$api_url = "https://api.bibleonline.ru";

function fixApiResult($data) {
    // fixing one bug in the API
    if ($data[0] === '(') {
        $data = substr($data, 1);
        $data = substr($data, 0, strlen($data)-2);
    }
    return $data;
}

$data = fixApiResult(file_get_contents($api_url . "/booklist"));

if ($data[0] === '(') {
    $data = substr($data, 1);
    $data = substr($data, 0, strlen($data)-2);
}
$books = json_decode($data, true);
if (!is_array($books)) {
    die("\nCan't parse books list. Json error: " . json_last_error() . "\n\n");
}

foreach ($books as $book) {
    if (isset($book['li'])) {
        $book_name = $book['li']['Name'];
        echo "\n\nParsing {$book_name}";

        $chapter = 1;

        do {
            $data = fixApiResult(file_get_contents($api_url . "/bible?q=" . urlencode("{$book_name} {$chapter}")));

            $verses = json_decode($data, true);
            if (!is_array($verses)) {
                die("\nCan't parse verses. Json error: " . json_last_error() . "\n\n");
            }

            echo "\n\nParsing Chapter: {$book_name} {$chapter}";

            foreach ($verses as $verse) {
                if (!isset($verse['v'])) {
                    continue;
                }

                $text = $verse['v']['t'];
                $number = $verse['v']['n'];

                echo "\n - {$text}";
            }

            $chapter++;
        } while (count($verses) > 0);


        die('Finished one book');
    }
}

echo "\n\nParsing complete.";