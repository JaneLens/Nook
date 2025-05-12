<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 归档
 *
 * @package custom
 */
$this->need('header.php'); ?>

<?php if ($this->request->getPathInfo() == '/Archives'|| $this->request->getPathInfo() == '/Archives.html') :?>
    
    <?php $this->need('parts/header.php'); ?>

    <div class="time-archive">
    	<?php 
        $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);   
        $year = 0; 
        $mon = 0;
        $output = '<div class="archive-container">';   
        
        while($archives->next()):   
            $year_tmp = date('Y', $archives->created);   
            $mon_tmp = date('m', $archives->created);   
            
            if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></div>';   
            if ($year != $year_tmp && $year > 0) $output .= '</section>';   
            
            if ($year != $year_tmp) {   
                $year = $year_tmp;   
                $output .= '<section class="archive-year">
                              <h3 class="year-title">'. $year .'</h3>
                              <div class="year-divider"></div>';    
            }   
            
            if ($mon != $mon_tmp) {
                $mon = $mon_tmp;
                $output .= '<div class="archive-month">
                              <div class="month-header">📜 '. $mon .'月</div>
                              <ul class="month-posts">';
            }
            
            // 文章类型图标
            
            if ($archives->fields->article_type == "say") { //<!-- 动态样式 -->
                $icon = '🌿';
            } elseif ($archives->fields->article_type == "books") { //<!-- 书单样式 -->
                $icon = '📖';
            } else { //<!-- 默认样式（文章） -->
                $icon = '✏️';
            }
            $output .= sprintf('
                <li class="post-item %s">
                    <span class="post-day">%s</span>
                    <a href="%s" class="post-link">%s %s</a>
                </li>',
                $archives->fields->article_type ?? '',
                date('j', $archives->created),
                $archives->permalink,
                $archives->title,
                $icon
            );
            
        endwhile;   
        
        $output .= '</ul></div></section></div>';
        echo $output;
        ?>
    </div>
<?php endif; ?>
<?php $this->need('footer.php'); ?>