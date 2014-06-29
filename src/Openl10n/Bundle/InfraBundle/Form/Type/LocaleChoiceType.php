<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Value\Localization\DisplayLocale;
use Openl10n\Domain\Translation\Repository\LocaleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocaleChoiceType extends AbstractType
{
    protected $localeRepository;

    public function __construct(LocaleRepository $localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $self = $this;

        $resolver->setDefaults(array(
            'choice_list' => function(Options $options) use ($self) {
                return $self->getChoiceList($options['restrict']);
            },
            'restrict' => array(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_locale_choice';
    }

    /**
     * Build a choice list object.
     *
     * @return SimpleChoiceList
     */
    public function getChoiceList(array $restrict = array())
    {
        $locales = $this->localeRepository->findAll();

        if (!empty($restrict)) {
            $locales = array_filter($locales, function($locale) use ($restrict) {
                return in_array((string) $locale, $restrict);
            });
        }

        // Sort locales by display names
        usort($locales, function($locale1, $locale2) {
            $displayLocale1 = (string) DisplayLocale::createFromLocale($locale1);
            $displayLocale2 = (string) DisplayLocale::createFromLocale($locale2);

            return strcmp($displayLocale1, $displayLocale2);
        });

        $keys = array_map(function($locale) {
            return (string) $locale;
        }, $locales);

        $values = array_map(function($locale) {
            return (string) DisplayLocale::createFromLocale($locale);
        }, $locales);

        return new SimpleChoiceList(array_combine($keys, $values));
    }
}
