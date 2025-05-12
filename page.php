<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 默认
 *
 * @package custom
 */
$this->need('header.php'); ?>

<!-- 页面主内容区 -->
    <article class="page-content">
            <?php $this->need('parts/header.php'); ?>
            <!-- 标题区 -->
            <header class="page-header fixed-header">
                <h1 class="page-title"><?php $this->title() ?></h1>
                <?php if ($this->fields->subtitle): ?>
                    <p class="page-subtitle"><?php $this->fields->subtitle(); ?></p>
                <?php endif; ?>
                <div class="page-divider">⋒⋒⋒</div>
            </header>

            <div class="post-content bg">
                <!-- 正文内容 -->
                
                <div class="moss-growth">
                    <?php $this->content(); ?>
                </div>
    
                <!-- 自定义字段扩展 -->
                <?php if ($this->fields->extra_content): ?>
                    <div class="page-extra">
                        <?php $this->fields->extra_content(); ?>
                    </div>
                <?php endif; ?>
    
                <!-- 页脚 -->
                <footer class="page-footer">
                    <div class="footer-divider"></div>
                    <p><?php $this->options->title(); ?> · <?php echo date('Y'); ?></p>
                </footer>
            </div>
    </article>
    <section class="">
        <?php $this->need('parts/comments.php'); ?>
    </section>
<?php $this->need('footer.php'); ?>