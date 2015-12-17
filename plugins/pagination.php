<?php


require  ROOT.DS.'lib'.DS.'button.class.php';
require  ROOT.DS.'lib'.DS.'pagination.class.php';


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$p = new Pagination(array(
    'itemsCount' => count($data['mainlist']),
    'itemsPerPage' => Config::get('adsperpage'),
    'currentPage' => $page
));
?>

<hr/>
<center>
<?php foreach ($p->buttons as $button) :
    if ($button->isActive) : ?>
        <a href = '?page=<?=$button->page?>'><?=$button->text?></a>
    <?php else : ?>
        <span style="color:#555555"><?=$button->text?></span>
    <?php endif;
endforeach; ?>
</center>