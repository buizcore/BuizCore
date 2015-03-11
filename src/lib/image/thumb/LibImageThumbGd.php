<?php

/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * class LibImageThumbGd
 *
 * @package net.buiz
 */
class LibImageThumbGd extends LibImageThumbAdapter
{
    
    /**
     * @var int $origName
     * @var int $thumbName
     * @var int $maxWidth
     * @var int $maxHeight
     * @var int $maxArea
     * @var int $quality
     * 
     * @throws LibImage_Exception wenn das bild nicht vorhanden ist oder nicht geöffnet werden kann
     */
    public function genThumbWithMaxArea($origName, $thumbName, $maxWidth, $maxHeight, $maxArea, $quality = 90)
    {

        $imgData = $this->openImage($origName);

        
        $actArea = $imgData->width * $imgData->height;
        $relation = $imgData->width / $imgData->height;
        $orientVert = ($imgData->width > $imgData->height);
        
        $newWidth = $imgData->width;
        $newHeight = $imgData->height;
        $newArea = $actArea;
       
        if ($orientVert) {
            if ($imgData->width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = round($newWidth / $relation);
                $newArea = $newWidth * $newHeight;
            }
        } else {
            if ($imgData->height > $maxHeight) {
                $newHeight = $maxHeight;
                $newWidth = round($newHeight * $relation);
                $newArea = $newWidth * $newHeight;
            }
        }
        
        if($newArea > $maxArea){
            
            $maxAreaRel = $newArea / $maxArea;
            $newHeight = round($newHeight * $maxAreaRel);
            $newWidth = round($newWidth * $maxAreaRel);
        }
  
        // neugenerieren des THUMBS
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($thumb, $imgData->res, 0, 0, 0, 0, $newWidth, $newHeight, $imgData->width, $imgData->height);

        if (! imagejpeg($thumb, $thumbName, $quality)) {
            throw new LibImage_Exception('Failed to create '. $thumb);
        }
    
    } // end public function genThumbWithMaxArea */

    /**
     * Enter description here...
     */
    public function genThumb()
    {
        $errorpic = PATH_GW."/themes/classic/ria/images/placeholder/not_available.png";
        
        if (file_exists($this->origName)) {
            $pic = $this->origName;
        } else {
            $pic = $errorpic;
        }
        
        try {
            $imgdata = getimagesize($pic);
            $org_width = $imgdata[0];
            $org_height = $imgdata[1];
            $type = $imgdata[2];
            
            switch ($type) {
                case 1:
                    {
                        if (! $im = ImageCreateFromGif($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                case 2:
                    {
                        if (! $im = ImageCreateFromJPEG($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                case 3:
                    {
                        if (! $im = ImageCreateFromPNG($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                      
                // Erstellen eines eigenen Vorschaubilds
                default:
                    {
                        // Standartbild hinkopieren
                        if (! $im = ImageCreateFromJPEG($errorpic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        // Neueinlesen der benötigten Daten
                        $imgdata = getimagesize($errorpic);
                        $org_width = $imgdata[0];
                        $org_height = $imgdata[1];
                    }
            } // ENDE SWITCH
              
            // Errechnen der neuen Größe
            if ($org_width > $org_height) {
                $verhaltnis = $org_width / $org_height;
                $new_width = $this->maxWidth;
                $new_height = round(($new_width / $verhaltnis));
            } else {
                $verhaltnis = $org_height / $org_width;
                $new_height = $this->maxHeight;
                $new_width = round(($new_height / $verhaltnis));
            }
            
            // neugenerieren des THUMBS
            $thumb = imagecreatetruecolor($new_width, $new_height);
            
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
            
            if (! imagejpeg($thumb, $this->thumbName, 95)) {
                throw new LibImage_Exception('Failed to create ' . $this->thumbName);
            }
            
            return true;
        } catch (LibImage_Exception $e) {
            return false;
        }
        
    } // end public function genThumb
    
    /**
     * @param string $fileName
     * @param string $newName
     * @param int $maxWidth
     * @param int $maxHeight
     * @throws LibImage_Exception
     * @return boolean
     */
    public function resize($newName = null, $maxWidth = null, $maxHeight = null)
    {
        if ($maxWidth) {
            $this->maxWidth = $maxWidth;
        }
        
        if ($maxHeight) {
            $this->maxHeight = $maxHeight;
        }
        
        try {
            
            $imgData = $this->openImage($this->origName);
            
            // Errechnen der neuen Größe
            if ($imgData->width > $imgData->height) {
                
                $relation = $imgData->width / $imgData->height;
                $newWidth = $this->maxWidth;
                $newHeight = round(($newWidth / $relation));
            } else {
                
                $relation = $imgData->height / $imgData->width;
                $newHeight = $this->maxHeight;
                $newWidth = round(($newHeight / $relation));
            }
            
            // neugenerieren des THUMBS
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            
            imagecopyresampled($thumb, $imgData->res, 0, 0, 0, 0, $newWidth, $newHeight, $imgData->width, $imgData->height);
            
            $path = pathinfo($newName);
            
            if (! file_exists($path['dirname'])) {
                SFilesystem::mkdir($path['dirname'], '0755');
            }
            
            if (! imagejpeg($thumb, $newName, 95)) {
                throw new LibImage_Exception('Failed to create ' . $newName);
            }
            
            return true;
        } catch (LibImage_Exception $e) {
            
            return false;
        }
    } // end public function resize
    
    /**
     *
     * @param string $fileName            
     * @param string $posX            
     * @param string $posY              
     * @param string $posW            
     * @param string $posH             
     * @param string $newWidth            
     * @param string $newHeight            
     * @param string $newName             
     * @param string $quality          
     * @throws LibImage_Exception
     * @return boolean
     */
    public function crop(        
        $fileName, 
        $posX = null, $posY = null, 
        $posW = null, $posH = null, 
        $newWidth = null, $newHeight = null,
        $newName = null, $quality = 90
    ) {
        
        
        if (is_object($fileName)) {
            $imageData = $fileName;
            $fileName = $imageData->imagePath.'/'.$imageData->imageName;
        } else {
            $imageData = $this->openImage($fileName);
        }
        
        if (! $newName)
            $newName = $fileName;
        
        
        try {
     
            
            $thumb = $this->cropImage($imageData, $posX, $posY, $posW, $posH);
            $this->saveImage($newName, $thumb, $imageData->quality );
           
            
            return true;
            
        } catch (LibImage_Exception $e) {
            
            return false;
        }
        
    } // end public function crop */
    
    /**
     * Diese Funktion erzeugt ein Bild mit Exakt der angegebenen
     * Breite und Höhe.
     * Ein allfälliger Überhang wird dabei
     * gleichmässig auf beiden Seiten abgeschnitten.
     *
     * @param string $fileName            
     * @param float $width            
     * @param float $height            
     * @param string $newName            
     */
    public function resizeCropOverflow($fileName, $width, $height, $newName = null)
    {
        if (! $newName)
            $newName = $fileName;
        
        $imgData = $this->openImage($fileName);
        
        $resizedImg = $this->resizeImageCropOverflow($imgData, $width, $height);
        
        $this->saveImage($newName, $resizedImg, 90);

    }//end public function resizeCropOverflow */

    /**
     *
     * @param string $fileName            
     * @param string $fallbackImg
     *            Bild welches verwendet werden soll wenn sich das Bild mit GD nicht öffnen lässt
     * @return LibImageData
     * @throws LibImage_Exception
     */
    public function openImage($fileName, $fallbackImg = null)
    {
        $imgData = new LibImageData();
        
        $imgData->imagePath = $fileName;
        
        if (! file_exists($fileName)) {
            throw new LibImage_Exception('Versucht ein nicht vorhandene Bild '.$fileName.' zu öffnen');
        }
        
        $errorpic = '';
        
        $imgdata = getimagesize($fileName);
        $imgData->width = $imgdata[0];
        $imgData->height = $imgdata[1];
        $imgData->type = $imgdata[2];
        
        switch ($imgData->type) {
            case 1:
                {
                    if (! $imgData->res = ImageCreateFromGif($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
            
            case 2:
                {
                    if (! $imgData->res = ImageCreateFromJPEG($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
            
            case 3:
                {
                    if (! $imgData->res = ImageCreateFromPNG($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
                  
            // Erstellen eines eigenen Vorschaubilds
            default:
                {
                    if($fallbackImg){
                        // Standartbild hinkopieren
                        if (! $im = ImageCreateFromJPEG($fallbackImg)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        // Neueinlesen der benötigten Daten
                        $imgdata = getimagesize($errorpic);
                        $imgData->width = $imgdata[0];
                        $imgData->height = $imgdata[1];
                        $imgData->type = $imgdata[2];
                    } else {
                        throw new LibImage_Exception("Das Angefragte Bild existiert nicht");
                    }

                }
        } // ENDE SWITCH
        
        return $imgData;
    
    } // end public function openImage
    
    /**
     * @param string $savePath
     * @param unknown $resource
     * @param number $quality
     * @throws LibImage_Exception
     */
    public function saveImage($savePath, $resource, $quality = 90)
    {
        
        SFilesystem::touchFileFolder($savePath);
        
        if (!imagejpeg($resource, $savePath, $quality)) {
            throw new LibImage_Exception('Failed to create ' . $savePath);
        }
        
    }//end public function saveImage */
    
    
    /**
     * Diese Funktion erzeugt ein Bild mit Exakt der angegebenen
     * Breite und Höhe.
     * Ein allfälliger Überhang wird dabei
     * gleichmässig auf beiden Seiten abgeschnitten.
     *
     * @param LibImageData $imgData
     * @param float $width
     * @param float $height
     */
    protected function resizeImageCropOverflow($imgData, $width, $height)
    {

        // Seitenverhältnis neu/alt bestimmen
        $scaleX = (float) $width / $imgData->width;
        $scaleY = (float) $height / $imgData->height;
    
        // Grösseres Seitenverhältnis zählt.
        $scale = max($scaleX, $scaleY);
    
        $dstW = $width;
        $dstH = $height;
        $dstX = $dstY = 0;
    
        // neue grösse berechnen, damit mindestens höhe bzw. breite korrekt ist
        $dstW = (int) ($scale * $imgData->width + 0.5);
        $dstH = (int) ($scale * $imgData->height + 0.5);
    
        // zielposition bestimmen
        $dstX = (int) (0.5 * ($width - $dstW));
        $dstY = (int) (0.5 * ($height - $dstH));
    
        // bild auf neue zielgrösse bestimmen. dabei ist erst eine seite korrekt
        $resizedImg = imagecreatetruecolor($dstW, $dstH);
        imagecopyresampled(
            $resizedImg, $imgData->res, 
            0, 0, 0, 0, 
            $dstW, $dstH, $imgData->width, $imgData->height
        );
    
        // prüfen ob abgeschnitten werden muss. falls ja neues bild mit definitiver grösse erstellen und altes verschoben einkopieren.
        if ($dstW != $width || $dstH != $height || $dstX != 0 || $dstY != 0) {
            $croppedImg = imagecreatetruecolor($width, $height);
            imagecopyresampled(
                $croppedImg, $resizedImg, 
                0, 0, - $dstX, - $dstY, $width, $height, 
                $width, $height
            );
            $resizedImg = $croppedImg;
        }
        
        return $resizedImg;
    
    }//end protected function resizeCropOverflow */
    
    /**
     * @param LibImageData $imgData
     * @param float $width
     * @param float $height
     */
    protected function cropImage(
        $imgData, 
        $posX, $posY,
        $posW, $posH
    ) {
    
        $thumb = imagecreatetruecolor($posW, $posH);
            
        imagecopyresampled(
            $thumb, $imgData->res,
            0,0,$posX,$posY,
            $posW,$posH,
            $posW,$posH
        );
    
        return $thumb;
    
    }//end protected function cropImage */
    
}// end class LibImageThumbGd
