<?php

function theme_url($uri)
{
    $CI =& get_instance();
    return $CI->config->base_url('assets/'.config_item('theme').'/'.$uri);
}


function theme_img($uri, $tag=false)
{
    if($tag)
    {
        return '<img src="'.theme_url('images/'.$uri).'" alt="'.$tag.'">';
    }
    else
    {
        return theme_url('images/'.$uri);
    }

}

function theme_js($uri, $tag=false)
{
    if($tag)
    {
        return '<script type="text/javascript" src="'.theme_url('js/'.$uri).'"></script>';
    }
    else
    {
        return theme_url('js/'.$uri);
    }
}


function theme_css($uri, $tag=false)
{
    if($tag)
    {
        $media=false;
        if(is_string($tag))
        {
            $media = 'media="'.$tag.'"';
        }
        return '<link href="'.theme_url('css/'.$uri).'" type="text/css" rel="stylesheet" '.$media.'/>';
    }

    return theme_url('css/'.$uri);
}