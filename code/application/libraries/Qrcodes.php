<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcodes {
    
    protected  $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
    }
    
    /**
     * 
     * @param string $text  内容
     * @param string $outfile 输出二维码文件名
     * @param string $level  容错级别
     * @param number $size 图片大小
     * @param number $margin
     * @param string $logo logo图片
     * @param string 保存的二维码文件名
     */
    public function qrpng($text, $outfile = FALSE, $level = 'L', $size = 3, $margin = 4, $logo = FALSE, $filename = FALSE)
    {
        require_once (APPPATH.'third_party/phpqrcode.php');
        QRcode::png($text, $outfile, $level, $size, $margin);
        
        $QR = imagecreatefromstring(file_get_contents($outfile));
        
        if ($logo !== FALSE)
        {            
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        
        if($filename !== FALSE)
        {
            imagepng($QR, $filename);
//             header("Content-type: image/png");
//             imagepng($QR);
        }
        else 
        {
            header("Content-type: image/png");
            imagepng($QR);
        }
        imagedestroy($QR);        
    }
    
    
    
}