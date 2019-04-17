<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Symfony\Component\Finder\Finder;

class AppExtension extends AbstractExtension implements \Twig\Extension\GlobalsInterface
{
    /** @var string */
    private $headerDir = 'assets/images/header/';

    public function getGlobals()
    {
        return [
            'headerImages' => $this->headerImages(),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('ucwords', 'ucwords')
        ];
    }

    public function headerImages()
    {
        $finder = new Finder();
        $finder->files()->in($this->headerDir);

        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getFilename();
        }
        shuffle($files);

        return $files;
    }

    public function getName()
    {
        return 'ext.ucwords';
    }
}