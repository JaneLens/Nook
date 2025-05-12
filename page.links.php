<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
/**
 * 友链
 *
 * @package custom
 */
$this->need('header.php'); ?>

    <div class="links-page">
    <?php if ($this->request->getPathInfo() == '/Links' || $this->request->getPathInfo() == '/Links.html') :?>
    
    <?php $this->need('parts/header.php'); ?>
	
        <!-- 标题区 -->
        <header class="page-header fixed-header">
            <h1 class="page-title"><?php $this->title() ?></h1>
            <?php if ($this->fields->subtitle): ?>
                <p class="page-subtitle"><?php $this->fields->subtitle(); ?></p>
            <?php endif; ?>
            <div class="page-divider">⋒⋒⋒</div>
        </header>
        
        <!-- 友链分类容器 -->
        <div class="links-container" id="links-list">
            <?php
                          $friends = [];
                          $friends_text = $this->options->Friends;
                          if ($friends_text) {
                            $friends_arr = explode("\r\n", $friends_text);
                            if (count($friends_arr) > 0) {
                              for ($i = 0; $i < count($friends_arr); $i++) {
                                $name = explode("||", $friends_arr[$i])[0];
                                $url = explode("||", $friends_arr[$i])[1];
                                $img = explode("||", $friends_arr[$i])[2];
                                $desc = explode("||", $friends_arr[$i])[3];
                                $friends[] = array("name" => trim($name), "url" => trim($url), "img" => trim($img), "desc" => trim($desc));
                              };
                            }
                          }
            ?>
            <?php if (sizeof($friends) > 0) : ?>
                <!-- 友链列表 -->
                <div class="links-grid">
                    <!-- 单个友链卡片 -->
                    <?php foreach ($friends as $item) : ?>
                    <a href="<?php echo $item['url']; ?>" class="link-card" target="_blank">
                        <div class="link-avatar">
                            <img src="<?php echo $item['img']; ?>" alt="站点头像" loading="lazy">
                        </div>
                        <div class="link-meta">
                            <span class="link-name"><?php echo $item['name']; ?></span>
                            <span class="link-desc"><?php echo $item['desc']; ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <!-- 更多友链... -->
                </div>
            <?php else:?>
            <section class="links-empty">
                <!-- 自然元素装饰 -->
                <div class="empty-decoration">
                    <div class="branch-shape"></div>
                </div>
            
                <!-- 主文案 -->
                <div class="empty-content">
                    <h2 class="empty-title">⌗ 林中空地</h2>
                    <p class="empty-desc">这里尚未有旅人留下足迹<br>但风会带来远方的消息...</p>
                </div>
            
                <!-- 互动按钮 -->
                <div class="empty-actions">
                    <a href="#comment-form" class="natural-button">
                        <span class="button-icon">✍</span>
                        成为第一位访客
                    </a>
                </div>
            </section>
        <?php endif; ?>

        </div>
        
        <section class="friendlink-guidelines">
            <!-- 申请条件 -->
            <div class="guidelines-section">
                <h3>✎ 基本要求</h3>
                <div class="moss-growth">
                    <?php $this->content(); ?>
                </div>
            </div>
        
            <!-- 本站信息 -->
            <div class="guidelines-section">
                <h3>✧ 本站信息</h3>
                <div class="site-card">
                    <div class="site-info">
                        <span class="site-name"><?php $this->options->title(); ?></span>
                        <span class="site-url"><?php $this->options->siteUrl(); ?></span>
                    </div>
                    <button class="copy-btn" data-clipboard-text="<?php $this->options->title(); ?> || <?php $this->options->siteUrl(); ?>">
                        <svg width="14" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        复制信息
                    </button>
                </div>
            </div>
        
            <!-- 申请格式 -->
            <div class="guidelines-section">
                <h3>✑ 申请格式</h3>
                <div class="format-example">
                    <p>请按以下格式留言或邮件告知：</p>
                    <pre>博客名称 || 博客地址 || 博客头像（可选） || 博客简介（20字内）</pre>
                </div>
            </div>
        
            <!-- 注意事项 -->
            <div class="guidelines-note">
                <p>申请通过后，你的站点将会出现在<a href="#links-list">友链森林</a>中</p>
            </div>
        </section>
    </div>
    
    <div id="comments" class="links-comments">
        <?php $this->comments()->to($comments); ?>
        <?php if ($this->allow('comment')): ?>
            <?php if ($comments->have()): ?>
                <div class="comment-header">
                    <h3 class="comment-count-title">
                        <?php 
                        $this->commentsNum(
                            '<span class="count-empty">⚓ 港湾尚静</span>',
                            '<span class="count-single">⛵ 一艘友邻小船</span>',
                            '<span class="count-multiple">🚢 %d 艘友邻船队</span>'
                        ); 
                        ?>
                    </h3>
                    <div class="comment-divider">⋒⋒⋒</div>
                </div>
    
                <?php $comments->listComments(); ?>
    
                <?php $comments->pageNav('旧笺', '新帆'); ?>
            <?php else: ?>
            
            <?php endif; ?>
        <?php else: ?>
            <div class="comments-closed">
                <div class="closed-illustration">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9.5 9l5 5m0-5l-5 5"></path>
                    </svg>
                </div>
                <h3 class="closed-title">港湾暂不接纳入港申请</h3>
                <p class="closed-message">
                    当前暂停新的友链建立<br>
                    现有连接仍可访问<a href="/Links.html">友链灯塔</a>
                </p>
                <div class="closed-decoration">⛵ ✧ ⚓</div>
            </div>
        <?php endif; ?>
    
        <?php if ($this->allow('comment')): ?>
            <div id="<?php $this->respondId(); ?>" class="respond">
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form" role="form">
                    <?php if ($this->user->hasLogin()): ?>
                    <div class="admin-status">
                        <span class="admin-icon">⚓</span>
                        <span class="admin-text">港湾管理员:<a class="admin" href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a></span>
                        <a href="<?php $this->options->logoutUrl(); ?>" class="admin-logout">退潮时离岸</a>
                    </div>
                    <?php endif; ?>
                    <!-- 表单头部 -->
                    <div class="form-header">
                        <div class="form-icon">🌊</div>
                        <h3>留下你的航海日志</h3>
                        <p>期待与你在数字海洋中联系</p>
                    </div>
                    
                     <!-- 输入区域 -->
                    <div class="form-grid">
                        <?php if (! $this->user->hasLogin()): ?>
                            <!-- 第一行 -->
                            <div class="form-group">
                                <label for="author" class="form-label">
                                    <span class="label-icon"><?php _e('🌿'); ?></span>
                                    <?php _e('小站芳名'); ?>
                                </label>
                                <input type="text" name="author" id="author" class="form-input" 
                                       placeholder="如：午后茶叙/枕边书阁" value="<?php $this->remember('author'); ?>" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="mail" class="form-label">
                                    <span class="label-icon"><?php _e('✉'); ?></span>
                                    <?php _e('信使方向'); ?>
                                </label>
                                <input type="email" name="mail" id="mail" class="form-input"
                                       placeholder="蒲公英会带着回信飘来" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                            </div>
                    
                            <!-- 第二行 -->
                            <div class="form-group full-width">
                                <label class="form-label" for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>>
                                    <span class="label-icon"><?php _e('🛤'); ?></span>
                                    <?php _e('林间小径'); ?>
                                </label>
                                <input type="url" name="url" id="url" class="form-input" autocomplete="off" 
                                       placeholder="请以http://开头的温暖路径" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                            </div>
                
                        <?php endif; ?>
                        <!-- 内容区 -->
                        <div class="form-group full-width">
                            <label for="textarea" class="form-label">
                                <span class="label-icon"><?php _e('🌸'); ?></span>
                                <?php _e('友链手札'); ?>
                            </label>
                            <textarea name="text" id="textarea" class="form-textarea" rows="6"
                                      placeholder="请用这样的格式书写：
        小站芳名 || 林间小径 || 花颜头像 || 几句暖心的自述（20粒字以内）
        示例：
        午后书房 || https://example.com || https://example.com/avatar.jpg || 记录阅读时光的温暖角落" required><?php $this->remember('text'); ?></textarea>
                        </div>
                    </div>
                    <!-- 提交按钮 -->
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            <span class="btn-icon">⚓</span>
                            抛下友谊之锚
                        </button>
                    </div>
                    
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
<?php $this->need('footer.php'); ?>