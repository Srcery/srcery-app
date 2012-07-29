<?php

namespace Srcery\Server;

class Instance extends Resource {

  /** @see Derivative */
  public $derivative = null;

  function load() {
    return $this->derivative->load();
  }

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
    // They wish to swap out images.
    if (!empty($_POST['swap'])) {
      $db = new MongoResource($this->db->collection);
      $inst = new Instance($db, array('id' => $_POST['swap']));
      $this->derivative->swap($inst->derivative);
      return parent::save();
    }
    else {
      $this->derivative->save();
      return parent::save();
    }
  }
}
?>