<?php
class Show
{
    public static function excerpt($name)
    {
        $text = substr($name, 0, 70);
        return $text . '...';
    }
}
