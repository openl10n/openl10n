<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Phrase;

class DeleteTranslationPhraseAction
{
    /**
     * @var Phrase
     */
    protected $phrase;

    public function __construct(Phrase $phrase)
    {
        $this->phrase = $phrase;
    }

    public function getPhrase()
    {
        return $this->phrase;
    }
}
