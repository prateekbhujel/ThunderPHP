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



}
