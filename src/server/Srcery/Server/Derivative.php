<?php

namespace Srcery\Server;

class Derivative extends Resource {
  public $width = 0;
  public $height = 0;

  /** @see Image */
  public $image = null;

  function load() {
    return $this->image->load();
  }

  function set($params) {
    parent::set($params);
    $this->width = !empty($params['width']) ? $params['width'] : 0;
    $this->height = !empty($params['height']) ? $params['height'] : 0;
    $image = !empty($params['image']) ? $params['image'] : array();
    $this->image = new Image($this->db, $image, $this->options);
  }

  function get() {
    return array_merge(parent::get(), array(
      'width' => $this->width,
      'height' => $this->height,
      'image' => $this->image->get(),
    ));
  }

  public function swap($derivative) {
    $this->image = $derivative->image;

    // TO-DO: BUILD DERIVATIVE FROM SWAPPED IMAGE
  }

  function save() {
    $this->image->save();
    return parent::save();
  }
}
?>
