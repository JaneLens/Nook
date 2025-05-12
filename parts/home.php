<!-- 1. 顶部标题区 (Banner) -->
<header class="site-banner fixed-header">
	<div class="title-wrapper">
		<h1 class="site-title">
			<?php $this->options->title(); ?>
		</h1>
		<p class="site-description">
			<?php $this->options->description(); ?>
		</p>
	</div>
	<!-- 图片放在右侧下方，用绝对定位控制 -->
	<img src="<?php $this->options->themeUrl('assets/style/coffee.png'); ?>" class="banner-decoration" alt="装饰图" width="120px" height="120px">
</header>

<div class="bg">
<!-- 2. 固定在标题区下方的导航栏 -->
<nav class="main-navigation">

	<!-- 中间导航菜单 -->
	<ul class="nav-menu">
	    <?php
            $blogUrl = $this->options->siteUrl;
            $archivesUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'Archives.html';
            $lvingUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'Lving.html';
            $linksUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'Links.html';
            $aboutUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'About.html';
        ?>
        <a data-title="文章集合" class="<?= ($this->is('Archives.html') || $this->is('page', 'Archives')) ? 'current' : '' ?>" href="<?= $archivesUrl ?>"><?php _e('辑露'); ?></a>
        <a data-title="来信交流" class="<?= ($this->is('Lving.html') || $this->is('page', 'Lving')) ? 'current' : '' ?>" href="<?= $lvingUrl ?>"><?php _e('痕间'); ?></a>
        <a data-title="友人站点" class="<?= ($this->is('Links.html') || $this->is('page', 'Links')) ? 'current' : '' ?>" href="<?= $linksUrl ?>"><?php _e('茶叙'); ?></a>
        <a data-title="个人简介" class="<?= ($this->is('About.html') || $this->is('page', 'About')) ? 'current' : '' ?>" href="<?= $aboutUrl ?>"><?php _e('棱泊'); ?></a>
	</ul>

</nav>

<!-- 3. 文章列表区 (核心内容) -->
<main class="content-area">
	<?php while($this->next()): ?>
	<article class="post-card">
		<!-- 第一行：时间 + 展开按钮 -->
		<div class="post-meta-line">
			<span class="post-relative-time">
				<?php echo get_lastyear($this->created); ?>
			</span>
			<button class="toggle-excerpt" aria-label="展开摘要">
				<svg class="toggle-icon" viewBox="0 0 24 24">
					<path d="M19 9l-7 7-7-7" /> <!-- 向下箭头图标 -->
				</svg>
			</button>
		</div>

		<!-- 第二行：标题 -->
		<h2 class="post-title">
			<a href="<?php $this->permalink() ?>">
				<?php $this->title() ?>
			</a>
		</h2>

		<!-- 第三行：摘要（默认隐藏） -->
		<div class="post-excerpt collapsed">
			<?php echo _getAbstract($this,300); ?>
		</div>

		<!-- 第四行：完整时间 -->
		<div class="post-full-time">
			<?php $this->date('Y-m-d H:i'); ?>
		</div>
	</article>
	<?php endwhile; ?>
</main>

<!-- 4. 分页导航 -->
<nav class="pagination">
	<span class="page-stats">
		<?php if($this->_currentPage>0): ?>
		<span class="page-current">
			<?php echo $this->_currentPage ?>
		</span>
		<span class="page-separator">/</span>
		<?php endif; ?>
		<span class="page-total">
			<?php echo ceil($this->getTotal() / $this->parameter->pageSize) ?> 篇</span>
	</span>
	<span class="page-links">
		<?php $this->pageLink('<svg class="nav-icon" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>', 'prev'); ?>
		<?php $this->pageLink('<svg class="nav-icon" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>', 'next'); ?>
	</span>
</nav>

<!-- 5. 结语板块 -->
<section class="post-footer">
	<div class="ending-divider">✦</div>
	<p class="ending-text">
		静阅至此，感谢你停留于此片文字间隙。
		<br>
		如风过林梢，愿这些字句曾轻轻拂过你的思绪。
	</p>
	<div class="ending-meta">
		<span class="current-season">
			<?php echo get_current_season(); ?>
		</span>
		<span>·</span>
		<span>
			<?php echo date('Y'); ?>
		</span>
	</div>
</section>
</div>