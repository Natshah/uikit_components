<?php

namespace Drupal\uikit_components;

/**
 * Class MimeStreamWrapper
 *
 * Provides a stream wrapper to retrieve mime type information from any source,
 * local or external. This steam wrapper allows us to retrieve the correct mime
 * type from external sources without requiring a third-party extension or
 * library, such as cURL, which may not be available to all hosts.
 */
class MimeStreamWrapper {

  const WRAPPER_NAME = 'mime';

  /**
   * @var resource
   */
  public $context;

  /**
   * @var bool
   */
  private static $isRegistered = FALSE;

  /**
   * @var callable
   */
  private $callBackFunction;

  /**
   * @var bool
   */
  private $eof = FALSE;

  /**
   * @var resource
   */
  private $fp;

  /**
   * @var string
   */
  private $path;

  /**
   * @var array
   */
  private $fileStat;

  /**
   * @return array
   */
  private function getStat() {
    if ($fStat = fstat($this->fp)) {
      return $fStat;
    }

    $size = 100;
    if ($headers = get_headers($this->path, TRUE)) {
      $head = array_change_key_case($headers, CASE_LOWER);
      $size = (int) $head['content-length'];
    }
    $blocks = ceil($size / 512);
    return [
      'dev' => 16777220,
      'ino' => 15764,
      'mode' => 33188,
      'nlink' => 1,
      'uid' => 10000,
      'gid' => 80,
      'rdev' => 0,
      'size' => $size,
      'atime' => 0,
      'mtime' => 0,
      'ctime' => 0,
      'blksize' => 4096,
      'blocks' => $blocks,
    ];
  }

  /**
   * @param string $path
   */
  public function setPath($path) {
    $this->path = $path;
    $this->fp = fopen($this->path, 'rb') or die('Cannot open file:  ' . $this->path);
    $this->fileStat = $this->getStat();
  }

  /**
   * @param int $count
   *
   * @return string
   */
  public function read($count) {
    return fread($this->fp, $count);
  }

  /**
   * Gets the stream path to the source using WRAPPER_NAME.
   *
   * @return string
   */
  public function getStreamPath() {
    return str_replace([
      'ftp://',
      'http://',
      'https://'
    ], self::WRAPPER_NAME . '://', $this->path);
  }

  /**
   * Creates a stream's context resource.
   *
   * @return resource
   */
  public function getContext() {
    if (!self::$isRegistered) {
      stream_wrapper_register(self::WRAPPER_NAME, get_class());
      self::$isRegistered = TRUE;
    }
    return stream_context_create(
      [
        self::WRAPPER_NAME => [
          'cb' => [$this, 'read'],
          'fileStat' => $this->fileStat,
        ]
      ]
    );
  }

  /**
   * @param $path
   * @param $mode
   * @param $options
   * @param $opened_path
   *
   * @return bool
   */
  public function stream_open($path, $mode, $options, &$opened_path) {
    if (!preg_match('/^r[bt]?$/', $mode) || !$this->context) {
      return FALSE;
    }
    $opt = stream_context_get_options($this->context);
    if (!is_array($opt[self::WRAPPER_NAME]) ||
      !isset($opt[self::WRAPPER_NAME]['cb']) ||
      !is_callable($opt[self::WRAPPER_NAME]['cb'])
    ) {
      return FALSE;
    }
    $this->callBackFunction = $opt[self::WRAPPER_NAME]['cb'];
    $this->fileStat = $opt[self::WRAPPER_NAME]['fileStat'];

    return TRUE;
  }

  /**
   * @param int $count
   *
   * @return mixed|string
   */
  public function stream_read($count) {
    if ($this->eof || !$count) {
      return '';
    }
    if (($s = call_user_func($this->callBackFunction, $count)) == '') {
      $this->eof = TRUE;
    }
    return $s;
  }

  /**
   * @return bool
   */
  public function stream_eof() {
    return $this->eof;
  }

  /**
   * @return array
   */
  public function stream_stat() {
    return $this->fileStat;
  }

  /**
   * @param int $castAs
   *
   * @return resource
   */
  public function stream_cast($castAs) {
    $read = NULL;
    $write = NULL;
    $except = NULL;
    return @stream_select($read, $write, $except, $castAs);
  }
}
