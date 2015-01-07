<?php

class TrombinoFromFluxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function trombinoAction()
    {
        $xml = simplexml_load_file('http://picasaweb.google.com/data/feed/base/user/107401320610499259896/albumid/6065229773950541889?alt=rss&kind=photo&authkey=Gv1sRgCNak7e60l-7VlgE&hl=fr');
        $this->view->data = $xml->channel->item;
    }


}

