<!-- 1. 头部操作栏 -->
<header class="post-operations">
    <!-- 左侧返回按钮 -->
    <button class="btn-back" onclick="history.back()">
        <svg viewBox="0 0 24 24" width="20">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    </button>
    
    <!-- 中间文章标题（新增部分） -->
    <div class="header-post-title"><?php $this->title() ?></div>
    
    <!-- 右侧分享按钮 -->
    <div class="post-tools">
        <button class="btn-tool btn-share">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link-icon lucide-external-link">
                <path d="M15 3h6v6" />
                <path d="M10 14 21 3" />
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
            </svg>
        </button>
    </div>
</header>