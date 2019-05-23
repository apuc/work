<?php


namespace common\classes;

use Yii;

class FileHandler
{
    public static function saveFileFromBase64($imageData, $folder){
        $data = explode(',', $imageData['dataUrl']);
        $image = base64_decode($data[1]);
        $dir = Yii::getAlias('@frontend/web/media/'.$folder);
        if (!file_exists($dir))
            mkdir($dir);
        $file_name = md5(time().Yii::$app->user->id);
        $folder1 = substr($file_name, 0, 2);
        $folder2 = substr($file_name, 2, 2);
        $file_name = substr($file_name, 4);
        $dir .= '/'.$folder1;
        if (!file_exists($dir))
            mkdir($dir);
        $dir .= '/'.$folder2;
        if (!file_exists($dir))
            mkdir($dir);
        $file_type = explode('/', $imageData['type'])[1];
        $file = fopen($dir . '/' . $file_name . '.' . $file_type, "wb");
        fwrite($file, $image);
        fclose($file);
        return '/media/'.$folder.'/'.$folder1.'/'.$folder2.'/'.$file_name.'.'.$file_type;
    }
}