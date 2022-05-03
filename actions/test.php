<?php
$hello_msg = _t('hello_world');
$version_msg = _t('app_version', ['version' => APP_VERSION]);
$output = json_output(true, "{$hello_msg}! {$version_msg}");

return json_response($output);
