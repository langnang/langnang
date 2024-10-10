<?php

namespace Illuminate\File;

/**
 * 
 */
class File extends \Core\Illuminate
{
  public $filepath;
  /**
   * 
   */
  public $dirname;
  /**
   * 
   */
  public $basename;
  /**
   * 
   */
  public $filename;
  /**
   * 
   */
  public $extension;
  /**
   * 
   */
  public $content;
  /**
   * file size
   */
  public $size;
  /**
   * file type
   */
  public $filetype;
  /**
   * inode change time of file
   */
  public $created_time;
  /**
   * file modification time
   */
  public $updated_time;
  /**
   * last access time of file
   */
  public $visited_time;
  public $created_at;
  public $updated_at;
  public $visited_at;
  /**
   * file permissions
   */
  public $permissions;
  /**
   * the md5 hash of a given file
   */
  public $md5;
  /**
   * file group
   */
  public $group;
  /**
   * file inode
   */
  public $inode;
  /**
   * file owner
   */
  public $owner;

  /**
   * 
   */
  protected $driver;
  function _init($filepath)
  {
    $this->filepath = $filepath;

    if (!is_file($filepath)) {
      $this->error_message = "path not file.";
      return $this;
    }
    if (!file_exists($filepath)) {
      $this->error_message = "file not exist.";
      return $this;
    };
    foreach (pathinfo($filepath) as $k => $v) {
      $this->{$k} = $v;
    }
    $this->size = filesize($filepath);
    $this->filetype = filetype($filepath);
    $this->group = filegroup($filepath);
    $this->inode = fileinode($filepath);
    $this->created_time = filectime($filepath);
    $this->created_at = date('Y-m-d h:i:s', $this->created_time);
    $this->updated_time = filemtime($filepath);
    $this->updated_at = date('Y-m-d h:i:s', $this->updated_time);
    $this->visited_time = fileatime($filepath);
    $this->visited_at = date('Y-m-d h:i:s', $this->visited_time);
    $this->owner = fileowner($filepath);
    $this->permissions = fileperms($filepath);
    $this->md5 = md5_file($filepath);
    return $this;
  }
  function of($filepath)
  {
    $this->_init($filepath);
    $this->setDriver();
    return $this->driver ?: $this;
  }
  function setDriver($extension = null)
  {
    $extension = $extension ?: $this->extension;
    if (empty($extension)) return;
    $driverClass = config('file.extensions.' . $extension);
    if (empty($driverClass)) return;
    $driver = new $driverClass($this);
    $this->driver = $driver;
  }
  function read($size = null)
  {
    $file = fopen($this->filepath, 'r');
    $this->content = fread($file, $size ?: $this->size);
    fclose($file);
    return $this->content;
  }
  function write() {}
  function prepend() {}
  function append() {}
  function download() {}
  function upload() {}
  function zip() {}
  function unzip() {}
}
