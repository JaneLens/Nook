<article class="post-article">
	
    <?php $this->need('parts/header.php'); ?>

    	<!-- 2. 标题与特色日期 -->
    	<div class="post-header fixed-header">
    		<h1 class="post-title">
    			<?php $this->title() ?>
    		</h1>
    		<div class="post-date">
    			<span class="date-day">
    				<?php echo date('d', $this->date->timeStamp); ?>
    			</span>
    			<div>
    				<span class="date-month-week">
    					<?php echo date('m', $this->date->timeStamp); ?>月 /
    					<?php 
                                        $weekdays = ['日', '一', '二', '三', '四', '五', '六'];
                                        echo '周' . $weekdays[date('w', $this->date->timeStamp)];
                                    ?>
    				</span>
    				<span class="post-views">
    					<?php $this->views(); ?> 次阅读</span>
    			</div>
    		</div>
    		<div class="post-divider">⌄⌄⌄</div>
    	</div>
    
    	<!-- 3. 文章内容 -->
    	<div class="post-content bg">
            
            <div class="moss-growth">
    		    <?php _article_changetext($this); ?>
    		</div>
    
    		<br>
    		<!-- 4. 结语 -->
    		<section class="post-footer">
    			<div class="ending-divider">✦</div>
    			<p class="ending-text">
    				文字是星火，你是拾光的人。
    				<br>
    				<span style="font-size:.7em;display:flex;justify-content:flex-end;">—— 记于
    					<?php echo get_current_season(); ?>末</span>
    			</p>
    		</section>
    	</div>
    	
    
</article>
<section class="">
    <?php $this->need('parts/comments.php'); ?>
</section>
