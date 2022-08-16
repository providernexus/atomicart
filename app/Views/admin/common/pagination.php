<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */

$all_links = $pager->links();

$totalpage      = count($all_links) - 1;
$currentpage    = (isset($_GET['page']) ? $_GET['page'] : 1);
$firstpage      = 1;
$lastpage       = $totalpage;
if($currentpage==1):
	$loopcounter = 5;
else:
	$loopcounter = ((($currentpage + 2) <= $lastpage) ? ($currentpage + 2) : ($lastpage+1));
endif;
$startCounter =  ((($currentpage - 2) >= 3) ? ($currentpage - 2) : 1);

?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
		
			<li>
				<a href="<?= $all_links[0]['uri'] ?>" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
		
		<?php
		for ($i = $startCounter; $i <= $loopcounter; $i++) {
			$pc = $i - 1;
			if(!isset($all_links[$pc])):
				break;
			endif;
		?>
			<li class="page-item <?php if ($all_links[$pc]['title'] == $currentpage) echo ' active'; ?>">
				<a href="<?= $all_links[$pc]['uri'] ?>" class="page-link">
					<?= $all_links[$pc]['title'] ?>
				</a>
			</li>
		<?php } ?>


		<li>
			<a href="<?= $all_links[$lastpage]['uri'] ?>" aria-label="<?= lang('Pager.last') ?>">
				<span aria-hidden="true"><?= lang('Pager.last') ?></span>
			</a>
		</li>

	</ul>
</nav>