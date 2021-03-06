<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\Admin\CRUD\Context\Request;

use FSi\Bundle\AdminBundle\Admin\Context\Request\AbstractFormValidRequestHandler;
use FSi\Bundle\AdminBundle\Event\AdminEvent;
use FSi\Bundle\AdminBundle\Event\FormEvent;
use FSi\Bundle\AdminBundle\Event\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormValidRequestHandler extends AbstractFormValidRequestHandler
{
    protected function action(FormEvent $event, Request $request): void
    {
        $event->getElement()->save($event->getForm()->getData());
    }

    protected function getPreSaveEventName(): string
    {
        return FormEvents::FORM_DATA_PRE_SAVE;
    }

    protected function getPostSaveEventName(): string
    {
        return FormEvents::FORM_DATA_POST_SAVE;
    }

    public function handleRequest(AdminEvent $event, Request $request): ?Response
    {
        $response = parent::handleRequest($event, $request);
        if ($response) {
            return $response;
        }

        $this->eventDispatcher->dispatch(FormEvents::FORM_RESPONSE_PRE_RENDER, $event);
        if ($event->hasResponse()) {
            return $event->getResponse();
        }

        return null;
    }
}
