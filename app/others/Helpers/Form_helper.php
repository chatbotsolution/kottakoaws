<?php

function show_form_error($validations,$field){
    if(isset($validations)){
        if($validations->hasError($field)){
            return $validations->getError($field);
        }else{
            return false;
        }
    }
}

?>