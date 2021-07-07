<?php

/*
 * This file is part of the clockoon/dokuwiki-commonmark-plugin package.
 *
 * (c) Sungbin Jeon <clockoon@gmail.com>
 *
 * Original code based on the followings:
 * - CommonMark JS reference parser (https://bitly.com/commonmark-js) (c) John MacFarlane
 * - league/commonmark (https://github.com/thephpleague/commonmark) (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DokuWiki\Plugin\Commonmark\Extension\Renderer\Block;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\BlockQuote;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Renderer\BlockRendererInterface;

final class BlockQuoteRenderer implements BlockRendererInterface
{
    /**
     * @param BlockQuote               $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $DWRenderer, bool $inTightList = false)
    {
        if (!($block instanceof BlockQuote)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        $filling = $DWRenderer->renderBlocks($block->children());
        $filling = preg_replace('/\n/', "\n>", $filling);

        if ($filling === '') {
            return '>' . $DWRenderer->getOption('inner_separator', "\n");
            //return new HtmlElement('blockquote', $attrs, $DWRenderer->getOption('inner_separator', "\n"));
        }

        return '>' . $filling . $DWRenderer->getOption('inner_separator', "\n");
        //return new HtmlElement(
        //    'blockquote',
        //    $attrs,
        //    $DWRenderer->getOption('inner_separator', "\n") . $filling . $DWRenderer->getOption('inner_separator', "\n")
        //);
    }
}
