<?php

namespace Geekhub\DreamBundle\Twig;

class DreamExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'dotdotdot' => new \Twig_Filter_Method($this, 'dotdotdot')
        );
    }

    public function dotdotdot($string, $number=10)
    {
        if (strlen($string) <= $number)
            return $string;
        if($string != '') {
            $str = '';
            $aStr = explode(' ', $string);

            for ($i=0; $number>$i; $i++) {
                if (isset($aStr[$i]))
                    $str .= $aStr[$i].' ';
            }

            if (count($aStr) > $number)
                $str = rtrim($str).'...';
            return $str;
        }

    }

    public function getName()
    {
        return 'dream_extension';
    }
}