<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class CategoryNewsEdit extends Page
{
    protected $path = '/admin/form/category_news/{id}?parent={parent_id}';

    protected function verifyPage(): void
    {
        if (!$this->has('css', '#page-header:contains("Edit element")')) {
            throw new UnexpectedPageException(sprintf("%s page is missing \"Edit element\" header", $this->path));
        }
    }
}