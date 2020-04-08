<?php
# Calculate chars in every chapter
$res = $db->query("UPDATE chapters SET chars=(SELECT SUM(LENGTH(content)) FROM verses WHERE chapter_id=chapters.id) ");