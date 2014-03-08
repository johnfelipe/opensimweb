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
require_once('inc/config.php');

/**
 * @brief Checks whether given asset is locally cached in given cache directory.
 *
 * @param asset_id (string) Assetid to check
 * @param cachedir jpeg2k / converted caching directory constant, as set in inc/config.php.
 * @return true if picture is cached in given directory, false otherwise.
 *
 * @author Anthony Le Mansec <a.lm@free.fr>
 */
function cache_check($asset_id, $cachedir=JP2_CACHE_DIR) {
	$cache_file = $cachedir.$asset_id;
	$file_max_age = time() - CACHE_MAX_AGE;
	if (!file_exists($cache_file))
		return (false);
	if (filemtime($cache_file) < $file_max_age) {
		// expired, removing old file:
		unlink($cache_file);
		return (false);
	}

	return (true);
}


/**
 * @brief Stores given picture to given cache directory.
 *
 * @param asset_id (string) UUID of the asset to store.
 * @param content (datas) raw image datas
 * @param cachedir local directory where to store image (as defined in inc/config.php)
 * @return false on error, true otherwise.
 */
function cache_write($asset_id, $content, $cachedir=JP2_CACHE_DIR) {
	$cache_file = $cachedir.$asset_id;
	$h = fopen($cache_file, "wb+");
	if (!$h)
		return (false);
	fwrite($h, $content);
	fclose($h);

	return (true);
}

?>
