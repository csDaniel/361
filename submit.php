<?php

require_once 'phapper/src/phapper.php';
$r = new Phapper\Phapper();
$r->setDebug(true);

        $response = array(
            "status" => "success",
            "messages" => []
        );

        $required = [
        array("name" => "title", "message" => "Title is required."),
        array("name" => "description", "message" => "Description is required."),
        array("name" => "category", "message" => "Category is required."),
        array("name" => "official", "message" => "Official is required."),
        ];

        foreach ($required as $entry => $field) {
            if (!isset($_POST['data'][$field['name']]) || $_POST['data'][$field['name']] == "") {
                $response['status'] = "error";
                array_push($response['messages'], $field['message']);
            }
        }

        if ($response['status'] != "error") {
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
        }

        echo json_encode($response);
?>
