<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TranslationContextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locales = array();

        if (null !== $project = $options['project']) {
            $locales = array_map(function($projectLocale) {
                return $projectLocale->getLocale()->toString();
            }, $project->getLocales()->toArray());
        }

        $builder
            ->add('source', 'openl10n_locale_choice', array(
                'restrict' => $locales,
                'label' => false,
            ))
            ->add('target', 'openl10n_locale_choice', array(
                'restrict' => $locales,
                'label' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'project' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_translation_context';
    }
}
