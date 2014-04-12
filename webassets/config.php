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
 * @file config.php
 * @brief Misc configuration variables.
 *
 * @author Anthony Le Mansec <a.lm@free.fr>
 */
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');
$robusturl = $osw->config['loginURI'];
$asset_address = $robusturl."/assets/";

define('ASSET_SERVER', $asset_address); // (OpenSim.ini: asset_server_url . "/assets/")
define('ASSET_SERVER_TIMEOUT', 8); // timeout in seconds, to wait while requesting an asset (default to 8)
define('ASSET_DO_RESIZE', true); // shall we resize picture to width=ASSET_RESIZE_FIXED_WIDTH ?
define('ASSET_RESIZE_FIXED_WIDTH', 150); // width in pixels

/* Will show following image if no asset was requested (malformed query) : */
define('ASSET_ID_NOTFOUND', 'cb2052ae-d161-43e9-b11b-c834217823cd');

/* will show following picture for Zero UUID (not found / malformed assets) : */
define('IMAGE_ID_ZERO', '/var/www/webassets/pic/uuid_zero'); // no extension here

define('IMAGE_DEFAULT_FORMAT', 'JPEG');

/* Re-use locally cached pictures (jp2k & converted) for 1 day before re-requesting it : */
define('CACHE_MAX_AGE', 86400); // 1 day

/* where to store cached pictures ? (user running your webserver needs write-permissions there : */
define('JP2_CACHE_DIR', '/var/www/webassets/cache/jp2/');
define('PIC_CACHE_DIR', '/var/www/webassets/cache/pic/');

?>
