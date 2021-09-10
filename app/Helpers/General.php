<?php

function uploadImage($folder,$img){
    
    $extention = $img->extension();
    $filename= time().'.'.$extention;
    $img->storeAs('public/'.$folder, $filename);
    
    return 'storage/'.$folder."/".$filename;
}