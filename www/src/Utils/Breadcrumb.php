<?php


namespace App\Utils;



class Breadcrumb
{
    protected $items = array();
    protected $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

//    a prendre si multi language site
//    public function add($textFr,$textEn, $url = null)
//    {
//        $local = $this->tools->requestStack->getCurrentRequest()->getLocale();
//
//        if ($local == 'fr'){
//            $text = $textFr;
//        } elseif ($local == 'en') {
//            $text = $textEn;
//        }
//        array_push($this->items, array('text' => $text, 'url' => $url));
//        return $this;
//    }


    public function add($textFr, $url = null)
    {
        $text = $textFr;
        array_push($this->items, array('text' => $text, 'url' => $url));
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

}