<?php

namespace Srcery\Server;

class Image extends File {
  protected function folder() {
    return empty($this->folder) ? 'images' : $this->folder;
  }

  protected function place_holder() {
    return empty($this->place_holder) ? 'placeholder.png' : $this->place_holder;
  }

  protected function allowed_extensions() {
    return array('jpg', 'jpeg', 'png', 'gif');
  }

  protected function post_name() {
    return 'img';
  }
}
