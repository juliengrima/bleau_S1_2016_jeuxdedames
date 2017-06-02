<?php

namespace CmsBundle\Twig;


class ExternalLinkFilter extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('external_link', array($this, 'externalLinkFilter')),
        );
    }

    /* source: http://stackoverflow.com/a/2762083/3924118 */
    public function externalLinkFilter($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        return $url;
    }

    public function getName()
    {
        return 'external_link_filter';
    }
}
