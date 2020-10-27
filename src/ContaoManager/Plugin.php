<?php

/*
 * This file is part of SkeletonBundle.
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\SkeletonBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MarcelMathiasNolte\SkeletonBundle\ContaoSkeletonBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoSkeletonBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
