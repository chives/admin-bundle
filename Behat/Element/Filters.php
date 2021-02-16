<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\Behat\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class Filters extends Element
{
    protected $selector = ['css' => 'form.filters'];

    public function hasBetweenFilter($filterName, $fromName, $toName): bool
    {
        return null !== $this->find('css', sprintf('label:contains("%s")', $filterName))
            && null !== $this->findField($fromName)
            && null !== $this->findField($toName);
    }

    public function hasChoiceFilter($filterName): bool
    {
        return true === $this->hasField($filterName) && 'select' === $this->findField($filterName)->getTagName();
    }
}
