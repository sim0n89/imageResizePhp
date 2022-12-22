<?php 
function imageResize($imagePath, $width, $height){
    $fullImagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
    if (!file_exists($fullImagePath)){
        return $imagePath;
    }
    $pathinfo = pathinfo($fullImagePath);
    $dir_path = str_replace('/img/', '/img/resized/', $pathinfo['dirname']);
    if (!file_exists($dir_path)){
        mkdir($dir_path, 0755, true);
    }
    $name = $pathinfo['filename'];
    $extension = mb_strtolower($pathinfo['extension']);
    $whithoutRoot = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir_path);
    $newFileName = $name.'_'.(string)$width.'_'.(string)$height.'.'.$extension;
    $newFile = $whithoutRoot.'/'.$newFileName;
    $newPath =$dir_path.'/'.$newFileName;
   
    if (file_exists($newPath)){
        return $newFile;
    }
    switch ($extension){
        case 'gif':
            $image = imagecreatefromgif($fullImagePath);
            break;
        
        case 'jpg':
            $image = imagecreatefromjpeg($fullImagePath);
            break;
        
        case 'png':
            $image = imagecreatefrompng($fullImagePath);
            break;
    }
    
    $imgResized = imagescale($image , $width, $height);
    switch ($extension){
        case 'gif':
            $image = imagegif($imgResized, $newPath);
            break;
        
        case 'jpg':
            $image = imagejpeg($imgResized, $newPath);
            break;
        
        case 'png':
            $image = imagepng($imgResized, $newPath);
            break;
    }
    return  $newFile;

}

?>