<?php

/* *********************************************************************
 * This Source Code Form is copyright of 51Degrees Mobile Experts Limited. 
 * Copyright 2014 51Degrees Mobile Experts Limited, 5 Charlotte Close,
 * Caversham, Reading, Berkshire, United Kingdom RG4 7BY
 * 
 * This Source Code Form is the subject of the following patent 
 * applications, owned by 51Degrees Mobile Experts Limited of 5 Charlotte
 * Close, Caversham, Reading, Berkshire, United Kingdom RG4 7BY: 
 * European Patent Application No. 13192291.6; and 
 * United States Patent Application Nos. 14/085,223 and 14/085,301.
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.
 * 
 * If a copy of the MPL was not distributed with this file, You can obtain
 * one at http://mozilla.org/MPL/2.0/.
 * 
 * This Source Code Form is "Incompatible With Secondary Licenses", as
 * defined by the Mozilla Public License, v. 2.0.
 * ********************************************************************* */

/**
 * @file
 * Provides functions to read a binary file generated by the .NET BinaryWriter.
 * See the MSDN page for details -
 * http://msdn.microsoft.com/en-us/library/system.io.binarywriter.aspx
 */

/**
 * Gets a bool from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return bool
 *   A bool value
 */
function fiftyone_degrees_read_bool($file) {
  $byte = fiftyone_degrees_read_byte($file);
  return $byte === 1;
}

/**
 * Gets a signed byte from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return int
 *   A signed byte as an integer
 */
function fiftyone_degrees_read_byte($file) {
  $byte = fread($file, 1);
  $value = unpack('c', $byte);
  return $value[1];
}

/**
 * Gets an unsigned byte from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return int
 *   An unsigned byte as an integer
 */
function fiftyone_degrees_read_ubyte($file) {
  $byte = fread($file, 1);
  $value = unpack('C', $byte);
  return $value[1];
}

/**
 * Gets a short from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return int
 *   A short as an integer
 */
function fiftyone_degrees_read_short($file) {
  $bytes = fread($file, 2);
  $value = unpack('s', $bytes);
  return $value[1];
}

/**
 * Gets an integer from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return bool
 *   An integer
 */
function fiftyone_degrees_read_int($file) {
  $bytes = fread($file, 4);
  $value = unpack('l', $bytes);
  return $value[1];
}

/**
 * Gets a string from at the current position in the file.
 *
 * @param file $file
 *   A pointer to the data file
 *
 * @return string
 *   A string
 */
function fiftyone_degrees_read_string($file) {
  $byte = fiftyone_degrees_read_ubyte($file);
  $length = 0;
  $shift = 0;
  while ($byte >= 128) {
    $length += ($byte - 128) << $shift;
    $shift += 7;
    $byte = read_ubyte($file);
  }
  $length += $byte << $shift;
  if ($length == 0)
    return '';
  $value = fread($file, $length - 0);
  fread($file, 1);
  return $value;
}