<?php
/*
 *  This file is part of WebAssets for OpenSimulator.
 *
 * WebAssets for OpenSimulator is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * WebAssets for OpenSimulator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WebAssets for OpenSimulator.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @file asset.php
 *
 * @brief Fetches, converts, caches, and display requested asset (picture).
 *
 * Usage :   <img src="http://.........../asset.php?id=<UUID>" width=...
 *
 * @param id (string) Asset UUID. eg: "cb2052ae-d161-43e9-b11b-c834217823cd"
 * @param format (string) Picture format, as accepted by imagemagick ("JPEG"|"GIF"|"PNG"|...)
 *
 * @author Anthony Le Mansec <a.lm@free.fr>
 */
require_once('inc/config.php');
require_once('inc/asset.php');

$format = (isset($_REQUEST['format'])) ? $_REQUEST['format'] : IMAGE_DEFAULT_FORMAT;
$asset_id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : ASSET_ID_NOTFOUND;

$asset_datas = asset_get($asset_id, $format);

// TODO : set an array of mime types according to 'format' arg
Header("Content-type: image/jpg");
echo $asset_datas;

?>
