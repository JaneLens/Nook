<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>

            <!-- 分享面板 (新增) -->
            <div class="share-panel">
                <div class="share-backdrop"></div>
                <div class="share-content">
                    <h3>分享文章</h3>
                    <ul class="share-options">
                        <li data-action="share-weibo">
                            <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                            <span>微博</span>
                        </li>
                        <li data-action="share-twitter">
                            <svg viewBox="0 0 24 24"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                            <span>Twitter</span>
                        </li>
                        <li data-action="share-facebook">
                            <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            <span>Facebook</span>
                        </li>
                    </ul>
                    <button class="btn-cancel">取消</button>
                </div>
            </div>
        </div><!-- container end -->
        <!-- 引入 Clipboard.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
        <script src="<?php $this->options->themeUrl('assets/style/main.js'); ?>"></script>
        <?php $this->footer(); ?>
    </body>
</html>