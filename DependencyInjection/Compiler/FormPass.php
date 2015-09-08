<?php

namespace Devmachine\Bundle\OntheioBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

        foreach (['layout', 'javascript'] as $template) {
            $resources[] = 'DevmachineOntheioBundle:Form:form_'.$template.'.html.twig';
        }

        $container->setParameter('twig.form.resources', $resources);
    }
}
