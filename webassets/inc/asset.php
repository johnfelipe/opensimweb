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
require_once('inc/cache.php');

/**
 * @brief Returns a default picture upon errors.
 *
 * @param format (string) file extension to return.
 * @return raws datas of image configured in inc/config.php
 * @author Anthony Le Mansec <a.lm@free.fr>
 */
function asset_get_zero($format) {
	$h = fopen(IMAGE_ID_ZERO.".".strtolower($format), "rb");
	$datas = fread($h, filesize(IMAGE_ID_ZERO.".".strtolower($format)));
	fclose($h);

	return ($datas);
}

/** 
 * @brief Returns raw image, in requested format. Also locally caches converted image.
 *
 * @param asset_id (string) Asset identifier, eg: "cb2052ae-d161-43e9-b11b-c834217823cd"
 * @param format (string) Format as accepted by ImageMagick ("JPEG"|"GIF"|"PNG"|...)
 * @return image raw datas, in given format.
 * TODO : allow custom image width (resizing) with suitable caching directory
 */
function asset_get($asset_id, $format='JPEG') {
	/* Zero UUID : returns default pic */
	if ($asset_id == "00000000-0000-0000-0000-000000000000") {
		return (asset_get_zero($format));
	}

	/*
	 * If requested asset was locally cached in
	 * requested format, returns it:
	 */
	 $cache_dir = PIC_CACHE_DIR;
	 $is_cached = cache_check($asset_id.".".strtolower($format), $cache_dir);
	 if ($is_cached) {
		$h = fopen($cache_dir.$asset_id.".".strtolower($format), "rb");
		if ($h) {
			$datas = fread($h, filesize($cache_dir.$asset_id.".".strtolower($format)));
			fclose ($h);
			return ($datas);
		}
	 }

	/*
	 * Get jp2 asset either from local cache or
	 * remote asset server :
	 */
	$cache_dir = JP2_CACHE_DIR;
	$is_cached = cache_check($asset_id, $cache_dir);
	if (!$is_cached) {
		$asset_url = ASSET_SERVER . $asset_id;
		$h = @fopen($asset_url, "rb");
		if (!$h) {
			return (asset_get_zero($format));
		}
		stream_set_timeout($h, ASSET_SERVER_TIMEOUT);
		$file_content = stream_get_contents($h);
		fclose($h);
		try {
			$xml = new SimpleXMLElement($file_content);
		} catch (Exception $e) {
			return (asset_get_zero($format));
		}
		$datas = base64_decode($xml->Data);
		cache_write($asset_id, $datas, $cache_dir);
	} else {
		$h = fopen($cache_dir.$asset_id, "rb");
		$datas = fread($h, filesize($cache_dir.$asset_id));
		fclose($h);
	}

	/* Convert original jp2 image to requested format :  */
	$_img = new Imagick();
	$_img->readImageBlob($datas); // TODO : error checking
	$_img->setImageFormat($format); // TODO : check for error

	if (ASSET_DO_RESIZE) {
		$original_height = $_img->getImageHeight();
		$original_width = $_img->getImageHeight();
		$multiplier = ASSET_RESIZE_FIXED_WIDTH / $original_width;
		$new_height = $original_height * $multiplier;
		$_img->resizeImage(ASSET_RESIZE_FIXED_WIDTH, $new_height, Imagick::FILTER_CUBIC, 1);
		// TODO : check for error
	}

	if (! $dump = $_img->getImageBlob()) {
		$reason      = imagick_failedreason( $img ) ;
		$description = imagick_faileddescription( $img ) ;
		print "handle failed!<BR>\nReason: $reason<BR>\nDescription: $description<BR>\n" ;
		exit ;
	}

	cache_write($asset_id.".".strtolower($format), $dump, PIC_CACHE_DIR);
	return ($dump);
}

?>
