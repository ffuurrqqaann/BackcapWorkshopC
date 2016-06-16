<?php
require_once '51Degrees/example/ExampleMaster.php';
require_once '51Degrees/core/51Degrees.php';

$ua = $_SERVER['HTTP_USER_AGENT'];
$properties = fiftyone_degrees_get_device_data($ua);

$mobileDeviceId = $properties['DeviceId'];