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
        $book_local_name = $book['li']['locale'];
        echo "\n\nParsing {$book_name}";

        if ('Genesis' === $book_name) continue;

        $db->insert('books', [
            'name' => $book_local_name,
        ]);
        $book_id = $db->last_insert_id('books');

        $chapter = 1;

        do {
            $data = fixApiResult(file_get_contents($api_url . "/bible?q=" . urlencode("{$book_name} {$chapter}")));

            $verses = json_decode($data, true);
            if (!is_array($verses)) {
                die("\nCan't parse verses. Json error: " . json_last_error() . "\n\n");
            }

            echo "\n\nParsing Chapter: {$book_name} {$chapter}";

            $db->insert('chapters', [
                'book_id' => $book_id,
                'number' => $chapter,
            ]);
            $chapter_id = $db->last_insert_id('chapters');

            foreach ($verses as $verse) {
                if (!isset($verse['v'])) {
                    continue;
                }

                $text = $verse['v']['t'];
                $number = $verse['v']['n'];

                $db->insert('verses', [
                    'chapter_id' => $chapter_id,
                    'number' => $number,
                    'content' => $text,
                ]);

                echo "\n - {$text}";
            }

            $chapter++;
        } while (count($verses) > 0);

    }
}

echo "\n\nParsing complete.";