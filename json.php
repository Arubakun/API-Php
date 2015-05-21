<?php
    function json_code($code, $object = null) {
        $out["code"] = $code;
        if($object) {
            $out[$object[0]] = $object[1];
        }
        
        return json_encode($out);
    }
?>