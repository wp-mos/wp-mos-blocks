<?php

  function mos_register_blocks_category($categories)
  {
    $categories[] = [
      'slug' => 'mos-category',
      'title' => 'Mos Blocks'
    ];

    return $categories;
  }
