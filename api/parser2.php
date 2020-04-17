<?php
// Parser to use saved JSON data files

include "db_config.php";
include "classes/class_mysql.php";

$db = new CMysql();

$langs = ['ru', 'ua', 'en'];

foreach ($langs as $lang) {
    $data[$lang] = simplexml_load_file("data/{$lang}.xml");
    echo "\nParsed {$lang}: ".count($data[$lang]) . " books";
}

$book_num = 0;
foreach ($data['en'] as $book) {
    echo "\n\nWill add book {$book_num}: {$data['en']->BIBLEBOOK[$book_num]['bname']}";

    $db->insert('books', [
        'name_en' => $data['en']->BIBLEBOOK[$book_num]['bname'],
        'name_ua' => $data['ua']->BIBLEBOOK[$book_num]['bname'],
        'name_ru' => $data['ru']->BIBLEBOOK[$book_num]['bname'],
    ]);
    $book_id = $db->last_insert_id('books');

    $chapter_num = 0;
    foreach ($data['en']->BIBLEBOOK[$book_num] as $chapter) {
        echo "\n - Chapter {$data['en']->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num]['cnumber']}\n     ";

        $db->insert('chapters', [
            'book_id' => $book_id,
            'number' => $data['en']->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num]['cnumber'],
        ]);
        $chapter_id = $db->last_insert_id('chapters');

        $verse_num = 0;
        foreach ($data['en']->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num] as $verse) {
            echo "{$data['en']->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num]->VERS[$verse_num]['vnumber']} ";

            foreach ($langs as $lang)
            $db->insert('verses', [
                'chapter_id' => $chapter_id,
                'lang' => $lang,
                'number' => $data['en']->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num]->VERS[$verse_num]['vnumber'],
                'content' => $data[$lang]->BIBLEBOOK[$book_num]->CHAPTER[$chapter_num]->VERS[$verse_num],
            ]);

            $verse_num++;
        }
        $chapter_num++;
    }
    $book_num++;
}

// $res = $db->query("SELECT * FROM books");
// $i = 0;
// while ($row = $db->fetch($res)) {
//     echo "\n{$row['name']}: {$data['ru']->BIBLEBOOK[$i]['bname']}, {$data['en']->BIBLEBOOK[$i]['bname']}";
//     $i++;
// }

echo "\n\nFinished.";