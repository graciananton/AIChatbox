<?php
class ErrorFormatter{
    public static function toHTmL($errors):string{
        
        $html = "";
        if(!empty($errors)){
            $html = "<div class='alert alert-danger'>";
            foreach ($errors as $e) {
                $html .= "<div style='display:inline-block;'>$e,</div> ";
            }
            $html .= " have errors</div>";
            return $html;
        }
        return $html;
    }
}