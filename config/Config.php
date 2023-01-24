<?php
  namespace config;

  class Config {
    public static $ROOT_DIR;
    public const TIMEZONE = 'Asia/Dhaka';

    public function __construct() {
      self::$ROOT_DIR = $_ENV['ROOT_DIR'];

      date_default_timezone_set(self::TIMEZONE);
    }
  }
?>