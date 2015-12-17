<?php

class Pagination
{

    public $buttons = array();

    public function __construct(Array $options = array('itemsCount' => 10, 'itemsPerPage' => 5, 'currentPage' => 1))
    {
        extract($options);

        /** @var int $currentPage */
        if (!$currentPage) {
            return;
        }

        /** @var int $pagesCount
         *  @var int $itemsCount
         *  @var int $itemsPerPage
         */
        $pagesCount = ceil($itemsCount / $itemsPerPage);

        if ($pagesCount == 1) {
            return;
        }

        /** @var int $currentPage */
        if ($currentPage > $pagesCount) {
            $currentPage = $pagesCount;
        }

        $this->buttons[] = new Button($currentPage - 1, $currentPage > 1, 'Пред.');

        for ($i = 1; $i <= $pagesCount; $i++) {
            $active = $currentPage != $i;
            $this->buttons[] = new Button($i, $active);
        }

        $this->buttons[] = new Button($currentPage + 1, $currentPage < $pagesCount, 'След.');
    }	
}