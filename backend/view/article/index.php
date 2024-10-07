<?php

/** @var array $articles */

foreach ($articles as $article) {
    if ($article['status'] === 'published') {
        echo "<h2>{$article['title']}</h2>";
        echo "<p>{$article['content']}</p>";
    }
}
?>

