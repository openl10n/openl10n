<?php

namespace Openl10n\Bundle\ApiBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;

class LocaleListener implements EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $requestStack;

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 16)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
    }

    public function __construct($defaultLocale = 'en', RequestContextAwareInterface $router = null, RequestStack $requestStack = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $locale = $this->getBestLocale($request);

        $this->setRequestLocale($request, $locale);
        $this->setRouterContext($request);
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (null === $this->requestStack) {
            return; // removed when requestStack is required
        }

        if (null !== $parentRequest = $this->requestStack->getParentRequest()) {
            $this->setRouterContext($parentRequest);
        }
    }

    private function getBestLocale(Request $request)
    {
        $acceptLanguage = $request->server->get('HTTP_ACCEPT_LANGUAGE');

        if (!$acceptLanguage) {
            return $this->defaultLocale;
        }

        $negotiator = new \Negotiation\LanguageNegotiator();
        $locale = $negotiator->getBest($acceptLanguage);

        if (!$locale) {
            return $this->defaultLocale;
        }

        return \Locale::canonicalize($locale->getValue());
    }

    private function setRequestLocale(Request $request, $locale)
    {
        $request->setDefaultLocale($this->defaultLocale);
        $request->setLocale($locale);
    }

    private function setRouterContext(Request $request)
    {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }
}
