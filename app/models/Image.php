<?php

namespace Core;

defined('ROOT') or die('Direct script access denied');

/**
 * Image Class
 *
 * This class provides functions for manipulating, resizing, cropping, and performing various operations on images.
 */
class Image
{

    

    /**
     * Resize an image to fit within a maximum size while maintaining aspect ratio.
     *
     * @param string $filename The path to the image file.
     * @param int $max_size    The maximum size for the longest dimension (e.g., width or height).
     *
     * @return string The path to the resized image or the original filename if the file doesn't exist or the type is not supported.
     */
    public function resize(string $filename, int $max_size = 700): string
    {
        if (!file_exists($filename))
            return $filename;

        $type = mime_content_type($filename);

        switch ($type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filename);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filename);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filename);
                break;
            default:
                return $filename;
                break;
        }

        $src_w = imagesx($image);
        $src_h = imagesy($image);

        if ($src_w > $src_h) {
            if ($src_w < $max_size)
                $max_size = $src_w;

            $dst_w = $max_size;
            $dst_h = ($src_h / $src_w) * $max_size;
        } else {

            if ($src_h < $max_size)
                $max_size = $src_h;

            $dst_h = $max_size;
            $dst_w = ($src_w / $src_h) * $max_size;
        }

        $dst_w = round($dst_w);
        $dst_h = round($dst_h);

        $dst_image = imagecreatetruecolor($dst_w, $dst_h);

        if ($type == 'image/png') 
        {
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image, true);
        }

        imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        imagedestroy($image);

        switch ($type) {
            case 'image/jpeg':
                imagejpeg($dst_image, $filename, 90);
                break;
            case 'image/png':
                imagepng($dst_image, $filename, 9);
                break;
            case 'image/gif':
                imagegif($dst_image, $filename);
                break;
            case 'image/webp':
                imagewebp($dst_image, $filename, 90);
                break;
            default:
                return $filename;
                break;
        }

        imagedestroy($dst_image);

        return $filename;
    }


    /**
     * Crop and resize an image to fit within specified maximum width and height.
     *
     * @param string $filename    The path to the image file.
     * @param int $max_width      The maximum width for the cropped image.
     * @param int $max_height     The maximum height for the cropped image.
     *
     * @return string The path to the cropped and resized image or the original filename if the file doesn't exist or the type is not supported.
     */
    public function crop(string $filename, int $max_width = 700, int $max_height = 700): string
    {
        if (!file_exists($filename))
            return $filename;

        $type = mime_content_type($filename);

        switch ($type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filename);
                $imagefunc = 'imagecreatefromjpeg';
                break;
            case 'image/png':
                $image = imagecreatefrompng($filename);
                $imagefunc = 'imagecreatefrompng';
                // Preserve transparency for PNG images
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filename);
                $imagefunc = 'imagecreatefromgif';
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filename);
                $imagefunc = 'imagecreatefromwebp';
                break;
            default:
                return $filename;
                break;
        }

        $src_w = imagesx($image);
        $src_h = imagesy($image);

        // Determine the appropriate maximum size while preserving aspect ratio
        if ($max_width > $max_height) {
            if ($src_w > $src_h) {
                $max = $max_width;
            } else {
                $max = ($src_h / $src_w) * $max_width;
            }
        } else {
            if ($src_w > $src_h) {
                $max = ($src_w / $src_h) * $max_height;
            } else {
                $max = $max_height;
            }
        }

        // Resize the image based on the calculated maximum size
        $this->resize($filename, $max);
        $image = $imagefunc($filename);

        $src_w = imagesx($image);
        $src_h = imagesy($image);

        $src_x = 0;
        $src_y = 0;

        // Calculate the cropping coordinates
        if ($max_width > $max_height) {
            $src_y = round(($src_h - $max_height) / 2);
        } else {
            $src_x = round(($src_w - $max_width) / 2);
        }

        // Create a new image for the cropped result
        $dst_image = imagecreatetruecolor($max_width, $max_height);

        if ($type == 'image/png') {
            // Preserve transparency for PNG images
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image, true);
        }

        // Crop and resize the image
        imagecopyresampled($dst_image, $image, 0, 0, $src_x, $src_y, $max_width, $max_height, $max_width, $max_height);
        imagedestroy($image);

        switch ($type) {
            case 'image/jpeg':
                imagejpeg($dst_image, $filename, 90);
                break;
            case 'image/png':
                imagepng($dst_image, $filename, 9);
                break;
            case 'image/gif':
                imagegif($dst_image, $filename);
                break;
            case 'image/webp':
                imagewebp($dst_image, $filename, 90);
                break;
            default:
                return $filename;
                break;
        }

        imagedestroy($dst_image);

        return $filename;
    }

    /**
     * Generate a thumbnail image from the given image file.
     *
     * @param string $filename The path to the original image file.
     * @param int $width       The width of the thumbnail.
     * @param int $height      The height of the thumbnail.
     *
     * @return string The path to the generated thumbnail image or the original filename if the file doesn't exist.
     */
    public function getThumbnail(string $filename, int $width = 700, int $height = 700): string
    {
        if (file_exists($filename)) {
            $ext = explode(".", $filename);
            $ext = end($ext);

            $dest = preg_replace("/\.$ext$/", "_thumbnail." . $ext, $filename);
            if(file_exists($dest))
                return $dest;
            
            copy($filename, $dest);

            // Crop the thumbnail image to the specified width and height
            $this->crop($dest, $width, $height);

            return $dest;
        }

        return $filename;
    }


}
