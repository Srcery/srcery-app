<?php

namespace Srcery\Server;

use Symfony\Component\HttpFoundation\Response;

class File extends Resource {

  /** Returns the extension of the provided file. */
  protected function extension($file) {
    return strtolower(substr($file, strrpos($file, '.') + 1));
  }

  /** The path of the file. */
  private function path() {

    // Make sure the id is not equal to the placeholder.
    if ($this->id != $this->place_holder()) {

      // Get the path of this file.
      $path = $this->folder() . '/' . $this->id;

      // Return the path.
      return $path;
    }
    
    return '';
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
      $file = $this->folder() . '/' . $this->place_holder();
    }

    // If the file exists, then stream it to the browser.
    if (file_exists($file) && ($fp = fopen($file, 'rb'))) {
      $response = new Response('', 200);
      $response->headers->set('Content-Type', 'image/png');
      $response->headers->set('Content-Length',  filesize($file));
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

    // The allowed extensions.
    $allowed_ext = $this->allowed_extensions();

    // Get the post name of the file.
    $post_name = $this->post_name();

    // See if our image upload exists.
    if (array_key_exists($post_name, $_FILES) && $_FILES[$post_name]['error'] == 0) {

      // Make sure the file path is valid.
      if ($file = $this->path()) {

        // Get the upload.
        $new_file = $_FILES[$post_name];

        // Check to see if this image has the extensions allowed.
        if (!in_array($this->extension($new_file['name']), $allowed_ext)) {
          return new Response('Only ' . implode(',', $allowed_ext) . ' files are allowed!', 406);
        }

        // For now just delete the old file.
        if (file_exists($file)) {
          unlink($file);
        }

        // Now move the image upload to the upload directory.
        if (move_uploaded_file($new_file['tmp_name'], $file)) {
          return new Response(json_encode(array('id' => $this->id)), 200);
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
    }
  }

  protected function folder() {
    return empty($this->folder) ? 'files' : $this->folder;
  }

  protected function place_holder() {
    return empty($this->place_holder) ? '' : $this->place_holder;
  }

  protected function allowed_extensions() {
    return array();
  }

  protected function post_name() {
    return 'file';
  }
}
?>