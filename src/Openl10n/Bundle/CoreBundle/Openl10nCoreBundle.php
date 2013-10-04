<?php

namespace Openl10n\Bundle\CoreBundle;

use Openl10n\Bundle\CoreBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Openl10nCoreBundle extends Bundle
{
        /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compiler\TranslationPass());
    }
}
