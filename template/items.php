<?php
/**
 * @var $key string
 * @var $name string
 * @var $checkout string
 * @var $items array
 * @var $enable boolean
 * @var $showEmpty boolean
 * @var $displayCartIcon boolean
 * @var $cartUrl string
 * @var $enable boolean
 * @var $iconUrl string
 * @var $text string
 * @var $productSubtotal int
 * @var $total int
 * @var $itemsTotal int
 */

use Jigoshop\Frontend\Pages;
use Jigoshop\Integration;
?>
<?php if (true == $showEmpty && empty($items)): ?>
	<?php if (true == $displayCartIcon) : ?>
		<?php if (false !== $enable) : ?>
            <li class="hsc-menu hsc-total">
                <a href="<?php echo esc_url($cartUrl) ?>">
                    <img src="<?php echo esc_url($iconUrl) ?>"/>&nbsp;&nbsp;<?php echo esc_attr($itemsTotal); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo esc_attr($productSubtotal); ?>
                </a>
            </li>
		<?php endif; ?>
	<?php else : ?>
        <li class="hsc-menu hsc-total">
            <a href="<?php echo esc_url($cartUrl); ?>">
				<?php echo esc_attr($text); ?>  <?php echo esc_attr($itemsTotal); ?>
				<?php print(__('|')) ?><?php echo esc_attr($productSubtotal); ?>
            </a>
        </li>
	<?php endif; ?>
    <!--Cart is not empty statement-->
<?php else : ?>
	<?php if (!empty($items)) : ?>
		<?php if (true == $displayCartIcon) : ?>
			<?php if (false !== $enable) : ?>
                <li class="hsc-menu hsc-total">
                    <a href="<?php echo esc_url($cartUrl) ?>">
                        <img src="<?php echo esc_url($iconUrl) ?>"/>&nbsp;&nbsp;<?php echo esc_attr($itemsTotal); ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo esc_attr($productSubtotal); ?>
                    </a>
                </li>
			<?php endif; ?>
		<?php else : ?>
            <li class="hsc-menu">
                <a href="<?php echo esc_url($cartUrl); ?>">
					<?php echo esc_attr($text); ?>  <?php echo esc_attr($itemsTotal); ?>
					<?php print(__('|')) ?><?php echo esc_attr($productSubtotal); ?>
                </a>
            </li>
		<?php endif; ?>
	<?php endif; ?>
    <!--End Cart is not empty statement-->
<?php endif; ?>