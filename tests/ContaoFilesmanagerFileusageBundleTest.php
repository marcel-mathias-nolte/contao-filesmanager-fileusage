<?php

/*
 * This file is part of ContaoFilesmanagerFileusageBundle.
 *
 * @package   ContaoFilesmanagerFileusageBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://github.com/marcel-mathias-nolte
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle\Tests;

use PHPUnit\Framework\TestCase;

class ContaoFilesmanagerFileusageBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoFilesmanagerFileusageBundle();

        $this->assertInstanceOf('MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle\ContaoFilesmanagerFileusageBundle', $bundle);
    }
}
