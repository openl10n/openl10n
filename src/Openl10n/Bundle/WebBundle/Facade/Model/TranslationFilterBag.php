<?php

namespace Openl10n\Bundle\WebBundle\Facade\Model;

use Symfony\Component\HttpFoundation\Request;

class TranslationFilterBag
{
    public $text;
    public $translated;
    public $approved;

    public static function createFromRequest(Request $request)
    {
        $self = new self();
        $self->text = $request->query->has('text') ? trim($request->query->get('text')) : null;
        $self->translated = $request->query->has('translated') ? trim($request->query->get('translated')) : null;
        $self->approved = $request->query->has('approved') ? trim($request->query->get('approved')) : null;

        return $self;
    }

    public function toArray()
    {
        $filters = array();

        if (null !== $this->text) {
            $filters['text'] = $this->text;
        }

        return $filters;
    }
}
