<?php

namespace Flame\Traits;

trait Twig {
    public function extendsTwig(&$twig)
    {
        $twig->addFunction(new \Twig_SimpleFunction('printFile', [$this, 'printFile']));
    }

    public function printFile($filename)
    {
        if (!$filename) {
            return;
        }

        if ($fr = fopen($filename, 'r')) {
            if (fpassthru($fr)) {
                fclose($fr);
            }
        }
    }
}
