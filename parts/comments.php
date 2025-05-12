<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
//如果你想使用其他评论头像插件，请注释下面这行代码！
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
?>
<div id="comments" class="article-comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($this->allow('comment')): ?>
        <?php if ($comments->have()): ?>
            <div class="comment-header">
                <h3 class="comment-count-title">
                    <?php 
                    $this->commentsNum(
                        '<span class="count-empty">🕊 尚无来信</span>',
                        '<span class="count-single">📜 一页心事</span>',
                        '<span class="count-multiple">📦 %d 件记忆包裹</span>'
                    ); 
                    ?>
                </h3>
                <div class="comment-divider">⋒⋒⋒</div>
            </div>

            <?php $comments->listComments(); ?>

            <?php $comments->pageNav('旧笺', '新帆'); ?>
        <?php else: ?>
            <div class="comment-empty">
                <div class="empty-illustration">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 21h16a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v3"></path>
                        <line x1="12" y1="11" x2="12" y2="17"></line>
                        <line x1="9" y1="14" x2="15" y2="14"></line>
                    </svg>
                </div>
                <h3 class="empty-title">信匣空置</h3>
                <p class="empty-desc">尚未有旅人留下字句<br>愿你是第一个写下故事的人</p>
                <div class="empty-action">
                    <a href="#comment-form" class="empty-button">
                        <span class="button-icon">✍️</span>
                        题写第一笺
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="comments-closed">
            <div class="closed-illustration">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    <line x1="12" y1="9" x2="12" y2="12"></line>
                    <line x1="12" y1="15" x2="12" y2="15"></line>
                </svg>
            </div>
            <h3 class="closed-title">信匣已封缄</h3>
            <p class="closed-message">
                此处的对话暂告一段落<br>
                或许在<a href="<?php $this->options->siteUrl(); ?>">其他篇章</a>还能遇见你
            </p>
            <div class="closed-decoration">✧ ⋄ ⋆ ✦</div>
        </div>
    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <div class="cancel-comment-reply">
                <?php $comments->cancelReply(); ?>
            </div>
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
                    <div class="form-icon">✧</div>
                    <h3>在此留下回音</h3>
                    <p>你的话语将化作港湾的涟漪</p>
                </div>
                
                 <!-- 输入区域 -->
                <div class="form-grid">
                    <?php if (! $this->user->hasLogin()): ?>
                        <!-- 第一行 -->
                        <div class="form-group">
                            <label for="author" class="form-label">
                                <span class="label-icon"><?php _e('✎'); ?></span>
                                <?php _e('你的名字'); ?>
                            </label>
                            <input type="text" name="author" id="author" class="form-input" 
                                   placeholder="（如候鸟掠过水面）" value="<?php $this->remember('author'); ?>" required>
                        </div>
                
                        <div class="form-group">
                            <label for="mail" class="form-label">
                                <span class="label-icon"><?php _e('✉'); ?></span>
                                <?php _e('信使方向'); ?>
                            </label>
                            <input type="email" name="mail" id="mail" class="form-input"
                                   placeholder="（只有海风知道）" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                        </div>
                
                        <!-- 第二行 -->
                        <div class="form-group full-width">
                            <label class="form-label" for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>>
                                <span class="label-icon"><?php _e('⌗'); ?></span>
                                <?php _e('你的岛屿'); ?>
                            </label>
                            <input type="url" name="url" id="url" class="form-input" autocomplete="off" 
                                   placeholder="（若你有一座小岛）" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                        </div>
            
                    <?php endif; ?>
                    <!-- 内容区 -->
                    <div class="form-group full-width">
                        <label for="textarea" class="form-label">
                            <span class="label-icon"><?php _e('♬'); ?></span>
                            <?php _e('潮汐絮语'); ?>
                        </label>
                        <textarea name="text" id="textarea" class="form-textarea" rows="6"
                                  placeholder="（浪花会记住这些字句）" required><?php $this->remember('text'); ?></textarea>
                    </div>
                </div>
                <!-- 提交按钮 -->
                <div class="form-footer">
                    <button type="submit" class="submit-btn">
                        <span class="btn-icon"><?php _e('🕊'); ?></span>
                        <?php _e('放逐漂流瓶'); ?>
                    </button>
                </div>
                
            </form>
        </div>
    <?php endif; ?>
</div>