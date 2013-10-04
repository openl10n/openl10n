<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

use Openl10n\Bundle\CoreBundle\Repository\LocaleRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocaleChoiceType extends AbstractType
{
    protected $localeRepository;

    public function __construct(LocaleRepositoryInterface $localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choice_list' => function(Options $options) {
                return $this->getChoiceList($options['restrict']);
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
     * @return ChoiceListInterface
     */
    protected function getChoiceList(array $restrict = array())
    {
        $locales = $this->localeRepository->getLocales();

        if (!empty($restrict)) {
            $locales = array_filter($locales, function($locale) use ($restrict) {
                return in_array($locale->toString(), $restrict);
            });
        }

        // Sort locales by display names
        usort($locales, function($locale1, $locale2) {
            return strcmp($locale1->getDisplayName(), $locale2->getDisplayName());
        });

        $keys = array_map(function($locale) {
            return (string) $locale;
        }, $locales);

        $values = array_map(function($locale) {
            return sprintf('%s (%s)', $locale->getDisplayName(), (string) $locale);
        }, $locales);

        return new SimpleChoiceList(array_combine($keys, $values));
    }
}
