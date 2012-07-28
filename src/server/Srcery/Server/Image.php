<?php

namespace Srcery\Server;

class Image extends File {
  function __construct($db, $params = array(), $options = array()) {
    parent::__construct($db, $params, $options);
    $this->extensions = array('jpg', 'jpeg', 'png', 'gif');
    $this->post_name = 'img';
  }
}
