<?php
namespace PhpKit\WebConsole\Lib;

class Debug
{
  /**
   * @param mixed $v
   * @return string
   */
  public static function getType ($v)
  {
    if (is_object ($v)) {
      $c = get_class ($v);
      return sprintf ('%s<sup><i>%d</i></sup>', self::shortenType ($c), self::objectId ($v));
    }
    if (is_array ($v))
      return 'array(' . count (array_keys ($v)) . ')';
    if (is_null ($v))
      return 'null';

    return gettype ($v);
  }

  /**
   * Interpolates context values into message placeholders, for use on PSR-3-compatible logging.
   *
   * @param string $message Message with optional placeholder with syntax {key}.
   * @param array  $context Array from where to fetch values corresponing to the interpolated keys.
   * @return string
   */
  public static function interpolate ($message, array $context = [])
  {
    // build a replacement array with braces around the context keys
    $replace = [];
    foreach ($context as $key => $val) {
      $replace['{' . $key . '}'] = $val;
    }
    // interpolate replacement values into the message and return
    return strtr ($message, $replace);
  }

  /**
   * Gets the base PHP namespace for this library.
   * @return string
   */
  public static function libraryNamespace ()
  {
    $c = explode ('\\', get_class ());
    array_pop ($c);
    return implode ('\\', $c);
  }

  /**
   * Returns an object's unique identifier (a short version), useful for debugging.
   * @param object $o
   * @return string
   */
  public static function objectId ($o)
  {
    static $ids = [];
    static $c = 0;
    $id = spl_object_hash ($o);
    if (isset($ids[$id]))
      return $ids[$id];
    return $ids[$id] = ++$c;
  }

  /**
   * @param string $c
   * @return string
   */
  public static function shortenType ($c)
  {
    $l = array_slice (explode ('\\', $c), -1)[0];
    return "<span title='$c'>$l</span>";
  }

}