<?php 
function create_thumb($filename, $width, $height)
{
    $instance =& get_instance();
    if (!is_file('./files/media/'.$filename)) {
        return false;
    }
    if (!is_image('./files/media/'.$filename)) {
        return false;
    }
    //check image processor extension
    if (extension_loaded('gd2')) {
        $lib = 'gd2';
    } else {
        $lib = 'gd';
    }
    $config['image_library'] = $lib;
    $config['source_image']    = './files/media/'.$filename;
    $config['new_image']    = './files/media/thumb_'.$filename;
    $config['create_thumb'] = true;
    $config['thumb_marker'] = "";
    $config['maintain_ratio'] = true;
    $config['width']    = $width;
    $config['height']    = $height;
    $config['master_dim']    = "height";
    $config['quality']    = "100%";

    $instance->load->library('image_lib');
    $instance->image_lib->initialize($config);
    $instance->image_lib->resize();
    $instance->image_lib->clear();
    return true;
}

function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];
     
    if (in_array($image_type, array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))) {
        return true;
    }
    return false;
}
