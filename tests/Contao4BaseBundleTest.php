<?php

/*
 * This file is part of SkeletonBundle.
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\SkeletonBundle\Tests;

use PHPUnit\Framework\TestCase;

class Contao4BaseBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new SkeletonBundle();

        $this->assertInstanceOf('MarcelMathiasNolte\SkeletonBundle\ContaoSkeletonBundle', $bundle);
    }
}
