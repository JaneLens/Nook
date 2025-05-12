<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Nook，意为“角落”。
 * 这是一个只属于你的安静一隅，像咖啡馆最里侧的座位，
 * 或深夜书桌前那盏暖黄的灯。
 * 极致的留白、温柔的间距，让文字成为唯一的主角。
 * —— 在这里，世界缩小到刚好容下一人、一篇文、一段思考。
 * 你可以在<a href="https://amrx.me">静语·偶尔有风</a>获得更多关于此皮肤的信息
 * 
 * <style>p{font-size:12px;color:#333;line-height:2;}</style>
 * 
 * @package Nook 
 * @author 简 / Jane
 * @version 1.8.0
 * @link https://amrx.me
 */
$this->need('header.php'); ?>

<?php if ($this->is('index')) ://判断首页 ?>
    <?php $this->need('parts/home.php'); ?>
<?php endif; ?>
<?php if ($this->is('post')) ://判断为阅读页面post ?>
    <?php $this->need('parts/archive.php'); ?>
<?php endif; ?>

<?php $this->need('footer.php'); ?>