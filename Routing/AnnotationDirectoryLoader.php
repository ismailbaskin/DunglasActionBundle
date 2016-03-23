<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dunglas\ActionBundle\Routing;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader as BaseAnnotationDirectoryLoader;

/**
 * Overrides the supported type.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AnnotationDirectoryLoader extends BaseAnnotationDirectoryLoader
{
    private $scannedDirectories;

    public function __construct(FileLocatorInterface $locator, AnnotationClassLoader $loader, array $scannedDirectories)
    {
        parent::__construct($locator, $loader);

        $this->scannedDirectories = $scannedDirectories;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        if (!parent::supports($resource, $type)) {
            return false;
        }

        try {
            $path = $this->locator->locate($resource);
        } catch (\Exception $e) {
            return false;
        }

        return isset($this->scannedDirectories[rtrim($path, '/')]);
    }
}
