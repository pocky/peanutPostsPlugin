<?php
 
  $tags_simple = array();
  foreach ( $tagSuggestions as $suggestion ) {
    $tags_simple[] =  $suggestion['suggested'];
  }
   
  echo json_encode($tags_simple);