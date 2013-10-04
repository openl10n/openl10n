<?php

namespace Openl10n\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TranslationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('openl10n.translation.loader')) {
            $this->addLoaders($container);
        }

        if ($container->hasDefinition('openl10n.translation.dumper')) {
            $this->addDumpers($container);
        }

    }

    protected function addLoaders(ContainerBuilder $container)
    {
        $loaders = array();
        foreach ($container->findTaggedServiceIds('translation.loader') as $id => $attributes) {
            $loaders[$id][] = $attributes[0]['alias'];
            if (isset($attributes[0]['legacy-alias'])) {
                $loaders[$id][] = $attributes[0]['legacy-alias'];
            }
        }

        $definition = $container->getDefinition('openl10n.translation.loader');
        foreach ($loaders as $id => $formats) {
            foreach ($formats as $format) {
                $definition->addMethodCall('addLoader', array($format, new Reference($id)));
            }
        }
    }

    protected function addDumpers(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('openl10n.translation.dumper');

        foreach ($container->findTaggedServiceIds('translation.dumper') as $id => $attributes) {
            $definition->addMethodCall('addDumper', array($attributes[0]['alias'], new Reference($id)));
        }
    }
}
