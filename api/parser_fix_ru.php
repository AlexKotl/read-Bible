<?php

include "db_config.php";
include "classes/class_mysql.php";

$db = new CMysql();


$data = simplexml_load_file("data/en.xml");

$book_num = 0;
$total_count = 0;
foreach ($data as $book) {

    $book_id = $book_num + 1;
    $row_book = $db->get_row("SELECT * FROM books WHERE id=$book_id");
    echo "\n\nFixing book ID {$book['bnumber']}";

    $chapter_num = 0;
    foreach ($data->BIBLEBOOK[$book_num] as $chapter) {

        $chapter_id = $db->get_row("SELECT id FROM chapters WHERE book_id={$book_id} AND number=".($chapter_num+1));

        $verse_num = 0;
        foreach ($data->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num] as $verse) {
            if (isset($verse['vref'])) continue;

            $db->insert('verses', [
                'chapter_id' => $chapter_id,
                'lang' => 'e2',
                'number' => $verse['vnumber'],
                'content' => addslashes($verse),
            ]);

            $total_count++;

            $verse_num++;

            echo "+";
        }

        $chapter_num++;
    }
    $book_num++;
}

echo "\n\nFinished. {$total_count} verses.";