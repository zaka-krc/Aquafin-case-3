<?php

namespace App\Helpers;

class MaterialImageHelper
{
    private static $imageMap = null;
    
    /**
     * Lees het tekstbestand en parse de afbeelding links
     */
    private static function loadImageMap()
    {
        if (self::$imageMap !== null) {
            return self::$imageMap;
        }
        
        $filePath = storage_path('app/public/materiaal_lijst.txt');
        
        if (!file_exists($filePath)) {
            self::$imageMap = [];
            return self::$imageMap;
        }
        
        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);
        
        self::$imageMap = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Parse line: "Material Name : https://url"
            if (strpos($line, ' : https://') !== false) {
                [$name, $url] = explode(' : https://', $line, 2);
                $url = 'https://' . trim($url);
                $name = trim($name);
                
                self::$imageMap[$name] = $url;
            }
        }
        
        return self::$imageMap;
    }
    
    /**
     * Vind afbeelding URL voor materiaal naam
     */
    public static function getImageUrl($materialName)
    {
        $imageMap = self::loadImageMap();
        
        // 1. Exacte match
        if (isset($imageMap[$materialName])) {
            return $imageMap[$materialName];
        }
        
        // 2. Fuzzy matching
        $normalizedMaterial = self::normalize($materialName);
        
        foreach ($imageMap as $key => $url) {
            $normalizedKey = self::normalize($key);
            
            // Bereken similarity
            $similarity = self::calculateSimilarity($normalizedMaterial, $normalizedKey);
            if ($similarity > 0.8) {
                return $url;
            }
        }
        
        // 3. Keyword matching
        foreach ($imageMap as $key => $url) {
            if (self::keywordMatch($materialName, $key)) {
                return $url;
            }
        }
        
        // 4. Fallback
        return 'https://via.placeholder.com/300x300/e5e7eb/6b7280?text=' . urlencode($materialName);
    }
    
    /**
     * Normalize string
     */
    private static function normalize($string)
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9\s]/', ' ', $string)));
    }
    
    /**
     * Calculate similarity
     */
    private static function calculateSimilarity($str1, $str2)
    {
        similar_text($str1, $str2, $percent);
        return $percent / 100;
    }
    
    /**
     * Keyword matching tussen materiaal en image key
     */
    private static function keywordMatch($materialName, $imageKey)
    {
        $materialWords = explode(' ', self::normalize($materialName));
        $keyWords = explode(' ', self::normalize($imageKey));
        
        $matches = 0;
        foreach ($materialWords as $materialWord) {
            if (strlen($materialWord) > 2) { // Skip kleine woorden
                foreach ($keyWords as $keyWord) {
                    if (strlen($keyWord) > 2 && (
                        strpos($materialWord, $keyWord) !== false || 
                        strpos($keyWord, $materialWord) !== false ||
                        levenshtein($materialWord, $keyWord) <= 1
                    )) {
                        $matches++;
                        break;
                    }
                }
            }
        }
        
        // Als meer dan 60% van de belangrijke woorden matchen
        $significantWords = count(array_filter($materialWords, fn($w) => strlen($w) > 2));
        return $significantWords > 0 && ($matches / $significantWords) > 0.6;
    }
}