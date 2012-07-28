<?php

namespace Srcery\Server;

class Instance extends Resource {

  /** @see Derivative */
  public $derivative = null;

  function set($params, $options = array()) {
    parent::set($params, $options);
    $derivative = !empty($params['derivative']) ? $params['derivative'] : array();
    $this->derivative = new Derivative($this->db, $derivative, $this->options);
  }

  function get() {
    // Return this object plus the parameters.
    return array_merge(parent::get(), array(
      'derivative' => $this->derivative->get(),
    ));
  }

  function save() {
    $this->derivative->save();
    return parent::save();
  }
}
?>