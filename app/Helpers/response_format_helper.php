<?php
if (!function_exists('response_success')) {
  function response_success($data, $message = '')
  {
    return [
      'status' => 1,
      'data' => $data,
      'message' => $message
    ];
  }
}
if (!function_exists('response_error')) {
  function response_error($data = '', $message = '')
  {
    return [
      'status' => 0,
      'data' => $data,
      'message' => $message
    ];
  }
}
