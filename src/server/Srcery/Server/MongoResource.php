<?php

namespace Srcery\Server;

class MongoResource {

  // Nobody should mess with these...
  public $collection = null;
  public $id = null;

  private $object = array();

  /** Construct the resource. */
  function __construct($collection) {
    $this->collection = $collection;
  }

  /** Load this resource. */
  protected function load() {
    $object = array();

    // If the collection or id doesn't exist, then load nothing...
    if (empty($this->collection) || empty($this->id)) {
      return array();
    }

    // Get the object if it hasn't already been loaded.
    if (empty($this->object)) {
      $this->object = $this->collection->findOne(array('id' => $this->id));
    }

    // Return the object.
    return $this->object;
  }

  /** Saves this resource. */
  public function save($object) {

    // If the collection doesn't exist, then save nothing...
    if (empty($this->collection) || empty($object)) {
      return false;
    }

    // If the object already exists in mongo.
    if (!empty($this->object['_id'])) {

      // Save the object in mongo.
      $this->object = array_merge($this->object, $object);
      $ret = $this->collection->save($this->object);
    }
    else {

      // Insert the object in mongo.
      $this->object = $this->collection->insert($object);;
    }

    // Return that this object was saved.
    return true;
  }

  /** Get the object representation from mongo. */
  public function get() {
    if ($object = $this->load()) {
      unset($object['_id']);
    }
    return $object ? $object : array();
  }

  /** Deletes this resource. */
  public function delete() {

    // If the collection doesn't exist, then save nothing...
    if (empty($this->collection) || empty($this->id)) {
      return false;
    }

    // Remove the object from mongo.
    $this->collection->remove(array('id' => $this->id));
    return true;
  }
}