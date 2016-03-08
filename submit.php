<?php

require_once 'phapper/src/phapper.php';
$r = new Phapper\Phapper();
$r->setDebug(true);
// get the values of all the POST variables we need
        $fields = array_map(
            function ($var) {
                return $_POST['data'][$var];
            },
            array('title', 'description', 'category', 'official')
        );
        $sub = 'cs361projectb';
        $encoded_title = '['.$fields[3].'] ['.$fields[2].'] '.$fields[0];
        $response = $r->submitTextPost($sub, $encoded_title, $fields[1]);
        echo json_encode($response);
?>
