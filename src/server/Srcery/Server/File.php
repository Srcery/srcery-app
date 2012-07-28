<?php

namespace Srcery\Server;

use Symfony\Component\HttpFoundation\Response;

class File extends Resource {

  public $folder = '';
  public $place_holder = '';
  public $extensions = array();
  public $post_name = 'file';
  public $size = 0;
  public $mimetype = '';
  public $name = '';

  // Construct the file.
  function __construct($db, $params = array(), $options = array()) {
    parent::__construct($db, $params, $options);
    $this->folder = $options['folder'];
    $this->place_holder = $options['place_holder'];
  }

  /** Returns the extension of the provided file. */
  protected function extension($file) {
    return strtolower(substr($file, strrpos($file, '.') + 1));
  }

  /** Returns the mime type. **/
  protected function getMimeType($file) {
    return 'text/plain';
  }

  /** The path of the file. */
  private function path() {

    // Make sure the id is not equal to the placeholder.
    if ($this->id != $this->place_holder) {

      // Get the path of this file.
      $path = $this->folder . '/' . $this->id;

      // Return the path.
      return $path;
    }

    return '';
  }

  function set($params) {
    parent::set($params);
    $this->size = !empty($params['size']) ? $params['size'] : 0;
    $this->mimetype = !empty($params['mimetype']) ? $params['mimetype'] : 'text/plain';
    $this->name = !empty($params['name']) ? $params['name'] : '';
  }

  function get() {
    return array_merge(parent::get(), array(
      'size' => $this->size,
      'mimetype' => !empty($this->mimetype) ? $this->mimetype : 'text/plain',
      'name' => !empty($this->name) ? $this->name : '',
    ));
  }

  /**
   * Loads a file.
   * @return Response
   */
  public function load() {

    // Get the file path.
    $file = $this->path();

    // If the file doesn't exist, then get the placeholder.
    if (!file_exists($file)) {
      $file = $this->folder . '/' . $this->place_holder;
    }

    // If the file exists, then stream it to the browser.
    if (file_exists($file) && ($fp = fopen($file, 'rb'))) {
      $response = new Response('', 200);
      $response->headers->set('Content-Type', $this->mimetype);
      $response->headers->set('Content-Length', filesize($file));
      fpassthru($fp);
      fclose($fp);
    }
    else {
      $response = new Response('File not found', 404);
    }

    return $response;
  }

  /**
   * Saves a file.
   * @return Response
   */
  public function save() {

    // See if our image upload exists.
    if (array_key_exists($this->post_name, $_FILES) && $_FILES[$this->post_name]['error'] == 0) {

      // Make sure the file path is valid.
      if ($file = $this->path()) {

        // Get the upload.
        $new_file = $_FILES[$this->post_name];

        // Check to see if this image has the extensions allowed.
        if (!in_array($this->extension($new_file['name']), $this->extensions)) {
          return new Response('Only ' . implode(',', $this->extensions) . ' files are allowed!', 406);
        }

        // For now just delete the old file.
        if (file_exists($file)) {
          unlink($file);
        }

        // Set the parameters.
        $this->name = $new_file['name'];
        $this->mimetype = $this->getMimeType($new_file['name']);
        $this->size = filesize($new_file['tmp_name']);

        // Now move the image upload to the upload directory.
        if (move_uploaded_file($new_file['tmp_name'], $file)) {
          return parent::save();
        }
      }
    }

    // Return a 406 error.
    return new Response('', 406);
  }

  /**
   * Deletes a file.
   * @return type
   */
  public function delete() {
    if ($file = $this->path() && file_exists($file)) {
      unlink($file);
      return parent::delete();
    }
    return new Response('', 406);
  }
}
?>