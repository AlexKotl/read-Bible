<?php
# Calculate chars in every chapter
$res = $db->query("UPDATE chapters SET chars=(SELECT SUM(LENGTH(content))/3 FROM verses WHERE chapter_id=chapters.id and lang='en') ");