<?php

namespace app\custom\helpers;

class Exif
{
    private $imagePath;

    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getData()
    {
        // Чтение байтов изображения
        $imageBytes = file_get_contents($this->imagePath);

        // Поиск EXIF данных
        return $this->findExifData($imageBytes);

        // if ($exifData !== false) {
        //     // Вывод EXIF данных
        //     echo "Camera: " . $exifData['Make'] . " " . $exifData['Model'] . "<br>";
        //     echo "Exposure: " . $exifData['ExposureTime'] . "<br>";
        //     echo "Aperture: " . $exifData['FNumber'] . "<br>";
        //     echo "ISO: " . $exifData['ISOSpeedRatings'] . "<br>";
        //     echo "Date Taken: " . $exifData['DateTimeOriginal'] . "<br>";
        // } else {
        //     echo "EXIF data not found.";
        // }
    }

    private function findExifData($imageBytes)
    {
        $exifHeader = [0xFF, 0xD8, 0xFF, 0xE1];
        $exifMarker = [0x45, 0x78, 0x69, 0x66, 0x00, 0x00];

        $exifStart = $this->findBytes($imageBytes, $exifHeader);
        return $exifStart;
        if ($exifStart !== false) {
            $exifOffset = $exifStart + count($exifHeader) + 2;
            $exifLength = unpack('n', substr($imageBytes, $exifOffset, 2))[1];

            $exifData = substr($imageBytes, $exifOffset + 2, $exifLength);
            $exifString = utf8_encode($exifData);

            $exifIndex = $this->findBytes($exifString, $exifMarker);
            if ($exifIndex !== false) {
                $exifTags = substr($exifString, $exifIndex + count($exifMarker));
                $exifMap = $this->parseExifTags($exifTags);

                return $exifMap;
            }
        }

        return false;
    }

    private function findBytes($haystack, $needle)
    {
        $haystackLength = strlen($haystack);
        $needleLength = count($needle);

        for ($i = 0; $i < $haystackLength - $needleLength; $i++) {
            $found = true;
            for ($j = 0; $j < $needleLength; $j++) {
                if ($haystack[$i + $j] !== chr($needle[$j])) {
                    $found = false;
                    break;
                }
            }
            if ($found) {
                return $i;
            }
        }

        return false;
    }

    private function parseExifTags($exifTags)
    {
        $exifMap = [];

        $tags = explode("\x00", $exifTags);
        foreach ($tags as $tag) {
            $keyValue = explode(':', $tag);
            if (count($keyValue) === 2) {
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);
                $exifMap[$key] = $value;
            }
        }

        return $exifMap;
    }
}
