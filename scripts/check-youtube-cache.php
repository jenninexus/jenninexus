<?php
$ids = [
  'PL9QBjNDhgNwRtiIPeSEi1HAa5ehnYpau0',
  'PL9QBjNDhgNwSELFNvTx9hpk3xbGduBpHY',
  'PL9QBjNDhgNwRaJX--_cZhEAJ8HbG9umiX',
  'PL9QBjNDhgNwRQONB9N2tIIhP0vPrkyNvy',
  'PL9QBjNDhgNwTnhBcU2WKXnjJN78OFW_JN',
  'PL9QBjNDhgNwSYG7c6qnwlqgRdQW-SWTHK'
];
$cacheDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'youtube';
foreach ($ids as $id) {
  $rss = 'https://www.youtube.com/feeds/videos.xml?playlist_id=' . $id;
  $hash = substr(md5($rss), 0, 12);
  $file = $cacheDir . DIRECTORY_SEPARATOR . $hash . '.json';
  echo "$id -> $hash -> ";
  if (file_exists($file)) {
    echo "EXISTS ";
    echo "mtime=" . date('c', filemtime($file)) . " size=" . filesize($file) . "\n";
  } else {
    echo "MISSING\n";
  }
}
