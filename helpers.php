<?php

/**
 * Shortcut for url::to()
 *
 * @return string
 */
function url() {
  return call_user_func_array('url::to', func_get_args());
}

/**
 * Even shorter shortcut for url::to()
 *
 * @return string
 */
function u() {
  return call_user_func_array('url::to', func_get_args());
}

/**
 * Redirects the user to a new URL
 * This uses the URL::to() method and can be super
 * smart with the custom url::to() handler. Check out
 * the URL class for more information
 */
function go() {
  call_user_func_array('redirect::to', func_get_args());
}

/**
 * Shortcut for r::get()
 *
 * @param   mixed    $key The key to look for. Pass false or null to return the entire request array.
 * @param   mixed    $default Optional default value, which should be returned if no element has been found
 * @return  mixed
 */
function get($key = null, $default = null) {
  return r::data($key, $default);
}

/**
 * Returns all params from the current url
 *
 * @return array
 */
function params() {
  return url::params();
}

/**
 * Get a parameter from the current URI object
 *
 * @param   mixed    $key The key to look for. Pass false or null to return the entire params array.
 * @param   mixed    $default Optional default value, which should be returned if no element has been found
 * @return  mixed
 */
function param($key = null, $default = null) {
  static $params;
  if(!$params) $params = url::params();
  return a::get($params, $key, $default);
}

/**
 * Smart version of return with an if condition as first argument
 *
 * @param boolean $condition
 * @param string $value The string to be returned if the condition is true
 * @param string $alternative An alternative string which should be returned when the condition is false
 */
function r($condition, $value, $alternative = null) {
  return $condition ? $value : $alternative;
}

/**
 * Smart version of echo with an if condition as first argument
 *
 * @param boolean $condition
 * @param string $value The string to be echoed if the condition is true
 * @param string $alternative An alternative string which should be echoed when the condition is false
 */
function e($condition, $value, $alternative = null) {
  echo r($condition, $value, $alternative);
}

/**
 * Alternative for e()
 *
 * @see e()
 */
function ecco($condition, $value, $alternative = null) {
  e($condition, $value, $alternative);
}

/**
 * Dumps any array or object in a human readable way
 *
 * @param mixed $variable Whatever you like to inspect
 * @param boolean $echo
 * @return string
 */
function dump($variable, $echo = true) {
  if(r::cli()) {
    $output = print_r($variable, true) . PHP_EOL;
  } else {
    $output = '<pre>' . print_r($variable, true) . '</pre>';
  }
  if($echo == true) echo $output;
  return $output;
}

/**
 * Generates a single attribute or a list of attributes
 *
 * @see html::attr();
 * @param string $name mixed string: a single attribute with that name will be generated. array: a list of attributes will be generated. Don't pass a second argument in that case.
 * @param string $value if used for a single attribute, pass the content for the attribute here
 * @return string the generated html
 */
function attr($name, $value = null) {
  return html::attr($name, $value);
}

/**
 * Creates safe html by encoding special characters
 *
 * @param string $text unencoded text
 * @return string
 */
function html($text, $keepTags = true) {
  return html::encode($text, $keepTags);
}

/**
 * Shortcut for html()
 *
 * @see html()
 */
function h($text, $keepTags = true) {
  return html::encode($text, $keepTags);
}

/**
 * Shortcut for xml::encode()
 */
function xml($text) {
  return xml::encode($text);
}

/**
 * The widont function makes sure that there are no
 * typographical widows at the end of a paragraph –
 * that's a single word in the last line
 *
 * @param string $string
 * @return string
 */
function widont($string = '') {
  return str::widont($string);
}

/**
 * Returns the memory usage in a readable format
 *
 * @return string
 */
function memory() {
  return f::niceSize(memory_get_usage());
}

/**
 * Determines the size/length of numbers, strings, arrays and files
 *
 * @param mixed $value
 * @return int
 */
function size($value) {
  if(is_numeric($value)) return $value;
  if(is_string($value))  return str::length(trim($value));
  if(is_array($value))   return count($value);
  if(f::exists($value))  return f::size($value) / 1024;
}

/**
 * Generates a gravatar image link
 *
 * @param string $email
 * @param int $size
 * @param string $default
 * @return string
 */
function gravatar($email, $size = 256, $default = 'mm') {
  return 'https://gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?d=' . urlencode($default) . '&s=' . $size;
}

/**
 * Checks / returns a csfr token
 *
 * @param string $check Pass a token here to compare it to the one in the session
 * @return mixed Either the token or a boolean check result
 */
function csfr($check = null) {

  // make sure a session is started
  s::start();

  if(is_null($check)) {
    $token = str::random(64);
    s::set('csfr', $token);
    return $token;
  }

  return ($check === s::get('csfr')) ? true : false;

}

/**
 * Shortcut for call_user_func_array with a better handling of arguments
 *
 * @param mixed $function
 * @param mixed $arguments
 * @return mixed
 */
function call($function, $arguments = array()) {
  if(!is_callable($function)) return false;
  if(!is_array($arguments)) $arguments = array($arguments);
  return call_user_func_array($function, $arguments);
}

/**
 * Parses yaml structured text
 *
 * @param string $text
 * @return string parsed text
 */
function yaml($string) {
  return yaml::decode($string);
}

/**
 * Shortcut to create a new thumb object
 *
 * @param mixed Either a file path or a Media object
 * @param array An array of additional params for the thumb
 * @return object Thumb
 */
function thumb($image, $params = array()) {
  return new Thumb($image, $params);
}

/**
 * Getter and setter for global path variables
 *
 * @param string $key
 * @param string $value
 * @return string
 */
function path($key, $value = null) {

  static $paths = array();

  if(is_null($value)) return $paths[$key];
  return $paths[$key] = $value;

}

/**
 * Simple email sender helper
 *
 * @param array $params
 */
function email($params = array()) {
  $email = new Email($params);
  return $email->send();
}

/**
 * Shortcut for the upload class
 */
function upload($to, $params = array()) {
  return new Upload($to, $params);
}

/**
 * Checks for invalid data
 *
 * @param array $data
 * @param array $rules
 * @param array $messages
 * @return mixed
 */
function invalid($data, $rules, $messages = array()) {
  $errors = array();
  foreach($rules as $field => $validations) {
    foreach($validations as $method => $options) {
      if(is_numeric($method)) $method = $options;
      if($method == 'required') {
        if(!isset($data[$field])) $errors[$field] = a::get($messages, $field, $field);
      } else {
        if(!is_array($options)) $options = array($options);
        array_unshift($options, a::get($data, $field));
        if(!call(array('v', $method), $options)) {
          $errors[$field] = a::get($messages, $field, $field);
        }
      }
    }
  }
  return array_unique($errors);
}
