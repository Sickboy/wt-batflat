<?php

namespace Inc\Modules\Map;

use Inc\Core\SiteModule;

class Site extends SiteModule
{
    protected $foo;
    public function init()
    {
        $this->foo = 'Hello';
	$this->_mapa();
    }
    public function routes()
    {
        // Simple:
//        $this->route('mapa', 'getIndex');
    }

    public function getIndex()
    {
        $page = [
            'title' => 'Mapa',
            'desc' => '',
            'content' => $this->draw('map.html')
        ];

        $this->setTemplate('strona.html');
        $this->tpl->set('page', $page);
    }

    public function _mapa()
    {
	$this->tpl->set('mapa', $this->draw('map.html'));
    }
}
