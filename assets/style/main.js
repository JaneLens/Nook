// 展开/收起文章摘要
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-excerpt').forEach(button => {
        button.addEventListener('click', () => {
            const postCard = button.closest('.post-card');
            const excerpt = postCard.querySelector('.post-excerpt');
            button.classList.toggle('active');
            excerpt.classList.toggle('collapsed');
        });
    });
});


// 粘住导航栏
document.addEventListener('DOMContentLoaded', function() {
  const mainNav = document.querySelector('.main-navigation');
  if (!mainNav) return; // 如果没有找到导航栏，直接退出

  const navOffsetTop = mainNav.offsetTop; // 获取元素距离顶部的初始位置

  function handleScroll() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop >= navOffsetTop) {
      mainNav.style.position = 'sticky'; // 滚动到导航栏位置时固定
      mainNav.style.top = '0'; // 确保 sticky 生效
    } else {
      mainNav.style.position = 'relative'; // 否则恢复默认
    }
  }

  // 使用 requestAnimationFrame 和 debounce 来优化滚动事件的性能
  let scrollTimeout = null;
  window.addEventListener('scroll', function() {
    if (scrollTimeout) {
      clearTimeout(scrollTimeout); // 清除之前的定时器
    }
    scrollTimeout = setTimeout(function() {
      requestAnimationFrame(handleScroll); // 使用 requestAnimationFrame 来优化性能
    }, 100); // 延迟 100 毫秒触发
  });
});
//文章标题隐藏 
document.addEventListener('DOMContentLoaded', () => {
  const scrollTrigger = window.innerHeight * 0.25; // 25vh
  
  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    
    if (scrollTop > scrollTrigger) {
      document.body.classList.add('scrolled-down');
    } else {
      document.body.classList.remove('scrolled-down');
    }
  });
});



// 友链信息复制
// 初始化 Clipboard.js
document.addEventListener('DOMContentLoaded', function() {
    // 初始化 Clipboard.js
    new ClipboardJS('.copy-btn', {
        text: function(trigger) {
            // 获取 data-clipboard-text 属性的值
            return trigger.getAttribute('data-clipboard-text');
        }
    });

    // 确保页面中存在 .copy-btn 元素
    const copyButton = document.querySelector('.copy-btn');
    if (copyButton) {
        // 添加点击事件监听器
        copyButton.addEventListener('click', function() {
            // 显示提示信息
            alert('信息已复制到剪贴板！');
        });
    } else {
        
    }
});

(function() {
    // 多功能懒加载库
    class UnifiedLazyLoad {
        constructor(options = {}) {
            // 默认配置
            this.config = {
                // 图片懒加载配置
                imgSelector: 'img[data-src]',
                bgSelector: '[data-bg-src]',
                imgRootMargin: '200px 0px',
                imgThreshold: 0.01,
                imgLoadingClass: 'lazy-loading',
                imgLoadedClass: 'lazy-loaded',
                imgErrorClass: 'lazy-error',
                imgDataAttr: 'src',
                bgDataAttr: 'bg-src',
                defaultImage: '',
                useNativeLazyLoad: false,
                
                // 多媒体嵌入配置
                mediaSelector: 'media-embed',
                mediaRootMargin: '300px 0px',
                mediaThreshold: 0.01,
                
                // 通用配置
                throttleTime: 200
            };
            
            // 合并用户配置
            Object.assign(this.config, options);
            
            // 存储观察器实例
            this.imgObserver = null;
            this.mediaObserver = null;
            
            // 初始化
            this.init();
        }
        
        // 初始化方法
        init() {
            // 初始化图片懒加载
            this.initImageLazyLoad();
            
            // 初始化多媒体懒加载
            this.initMediaLazyLoad();
        }
        
        // 图片懒加载初始化
        initImageLazyLoad() {
            // 检查是否支持原生懒加载
            if (this.config.useNativeLazyLoad && 'loading' in HTMLImageElement.prototype) {
                this.initNativeImageLazyLoad();
            } 
            // 检查是否支持 IntersectionObserver
            else if ('IntersectionObserver' in window) {
                this.initIntersectionImageObserver();
            } 
            // 回退到传统滚动事件监听
            else {
                this.initScrollImageListener();
            }
        }
        
        // 多媒体懒加载初始化
        initMediaLazyLoad() {
            if ('IntersectionObserver' in window) {
                this.initIntersectionMediaObserver();
            } else {
                this.initScrollMediaListener();
            }
        }
        
        /* 图片懒加载相关方法 */
        initNativeImageLazyLoad() {
            const images = document.querySelectorAll(this.config.imgSelector);
            images.forEach(img => {
                img.loading = 'lazy';
                this.loadImage(img);
            });
            
            const bgElements = document.querySelectorAll(this.config.bgSelector);
            bgElements.forEach(el => {
                this.loadBackgroundImage(el);
            });
        }
        
        initIntersectionImageObserver() {
            this.imgObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        
                        if (target.tagName.toLowerCase() === 'img') {
                            this.loadImage(target);
                        } else if (target.hasAttribute(`data-${this.config.bgDataAttr}`)) {
                            this.loadBackgroundImage(target);
                        }
                        
                        observer.unobserve(target);
                    }
                });
            }, {
                rootMargin: this.config.imgRootMargin,
                threshold: this.config.imgThreshold
            });
            
            this.observeImageElements();
        }
        
        initScrollImageListener() {
            this.checkImageVisibility();
            
            let timer = null;
            const handler = () => {
                if (timer) clearTimeout(timer);
                timer = setTimeout(() => {
                    this.checkImageVisibility();
                    timer = null;
                }, this.config.throttleTime);
            };
            
            window.addEventListener('scroll', handler);
            window.addEventListener('resize', handler);
        }
        
        observeImageElements() {
            document.querySelectorAll(this.config.imgSelector).forEach(img => {
                this.imgObserver.observe(img);
            });
            
            document.querySelectorAll(this.config.bgSelector).forEach(el => {
                this.imgObserver.observe(el);
            });
        }
        
        checkImageVisibility() {
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;
            
            document.querySelectorAll(this.config.imgSelector).forEach(img => {
                if (this.isElementInViewport(img, scrollY, windowHeight, this.config.imgRootMargin) && 
                    !img.classList.contains(this.config.imgLoadedClass)) {
                    this.loadImage(img);
                }
            });
            
            document.querySelectorAll(this.config.bgSelector).forEach(el => {
                if (this.isElementInViewport(el, scrollY, windowHeight, this.config.imgRootMargin) && 
                    !el.classList.contains(this.config.imgLoadedClass)) {
                    this.loadBackgroundImage(el);
                }
            });
        }
        
        /* 多媒体懒加载相关方法 */
        initIntersectionMediaObserver() {
            this.mediaObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        this.loadMediaContent(target);
                        observer.unobserve(target);
                    }
                });
            }, {
                rootMargin: this.config.mediaRootMargin,
                threshold: this.config.mediaThreshold
            });
            
            this.observeMediaElements();
        }
        
        initScrollMediaListener() {
            this.checkMediaVisibility();
            
            let timer = null;
            const handler = () => {
                if (timer) clearTimeout(timer);
                timer = setTimeout(() => {
                    this.checkMediaVisibility();
                    timer = null;
                }, this.config.throttleTime);
            };
            
            window.addEventListener('scroll', handler);
            window.addEventListener('resize', handler);
        }
        
        observeMediaElements() {
            document.querySelectorAll(this.config.mediaSelector).forEach(el => {
                this.mediaObserver.observe(el);
            });
        }
        
        checkMediaVisibility() {
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;
            
            document.querySelectorAll(this.config.mediaSelector).forEach(el => {
                if (this.isElementInViewport(el, scrollY, windowHeight, this.config.mediaRootMargin) && 
                    !el.classList.contains('loaded')) {
                    this.loadMediaContent(el);
                }
            });
        }
        
        /* 通用方法 */
        isElementInViewport(el, scrollY, windowHeight, margin = '0px') {
            const rect = el.getBoundingClientRect();
            const marginValue = parseInt(margin, 10) || 0;
            
            return (
                rect.bottom >= -marginValue &&
                rect.top <= (windowHeight + marginValue)
            );
        }
        
        // 加载图片
        loadImage(img) {
            img.classList.add(this.config.imgLoadingClass);
            
            if (this.config.defaultImage && !img.src) {
                img.src = this.config.defaultImage;
            }
            
            const newImg = new Image();
            newImg.src = img.getAttribute(`data-${this.config.imgDataAttr}`);
            
            newImg.onload = () => {
                img.classList.remove(this.config.imgLoadingClass);
                img.classList.add(this.config.imgLoadedClass);
                img.src = newImg.src;
                this.triggerEvent(img, 'lazyloaded');
            };
            
            newImg.onerror = () => {
                img.classList.remove(this.config.imgLoadingClass);
                img.classList.add(this.config.imgErrorClass);
                this.triggerEvent(img, 'lazyerror');
            };
        }
        
        // 加载背景图
        loadBackgroundImage(el) {
            el.classList.add(this.config.imgLoadingClass);
            const bgUrl = el.getAttribute(`data-${this.config.bgDataAttr}`);
            
            const img = new Image();
            img.src = bgUrl;
            
            img.onload = () => {
                el.classList.remove(this.config.imgLoadingClass);
                el.classList.add(this.config.imgLoadedClass);
                el.style.backgroundImage = `url(${bgUrl})`;
                this.triggerEvent(el, 'lazyloaded');
            };
            
            img.onerror = () => {
                el.classList.remove(this.config.imgLoadingClass);
                el.classList.add(this.config.imgErrorClass);
                this.triggerEvent(el, 'lazyerror');
            };
        }
        
        // 加载多媒体内容
        loadMediaContent(el) {
            const iframe = el.querySelector('iframe');
            if (iframe && iframe.dataset.src) {
                iframe.src = iframe.dataset.src;
                el.classList.add('loaded');
                this.triggerEvent(el, 'medialoaded');
            }
        }
        
        // 触发自定义事件
        triggerEvent(element, eventName) {
            const event = new Event(eventName, { bubbles: true, cancelable: true });
            element.dispatchEvent(event);
        }
        
        // 销毁实例
        destroy() {
            if (this.imgObserver) {
                this.imgObserver.disconnect();
                this.imgObserver = null;
            }
            
            if (this.mediaObserver) {
                this.mediaObserver.disconnect();
                this.mediaObserver = null;
            }
            
            window.removeEventListener('scroll', this.checkImageVisibility);
            window.removeEventListener('resize', this.checkImageVisibility);
            window.removeEventListener('scroll', this.checkMediaVisibility);
            window.removeEventListener('resize', this.checkMediaVisibility);
        }
    }
    
    // 全局暴露 API
    window.UnifiedLazyLoad = UnifiedLazyLoad;
    
    // 自动初始化
    document.addEventListener('DOMContentLoaded', () => {
        new UnifiedLazyLoad();
    });
})();
document.addEventListener('DOMContentLoaded', function() {
    // 获取当前文章URL和标题
    const articleUrl = window.location.href;
    const articleTitle = document.title;
    
    // 分享面板控制
    const btnShare = document.querySelector('.btn-share');
    const sharePanel = document.querySelector('.share-panel');
    const btnCancel = document.querySelector('.btn-cancel');
    
    btnShare.addEventListener('click', function() {
        sharePanel.style.display = 'block';
        setTimeout(() => {
            sharePanel.classList.add('active');
        }, 10);
    });
    
    btnCancel.addEventListener('click', closeSharePanel);
    document.querySelector('.share-backdrop').addEventListener('click', closeSharePanel);
    
    function closeSharePanel() {
        sharePanel.classList.remove('active');
        setTimeout(() => {
            sharePanel.style.display = 'none';
        }, 300);
    }
    
    // 分享功能实现
    const shareOptions = document.querySelectorAll('.share-options li');
    
    shareOptions.forEach(option => {
        option.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            
            switch(action) {
                case 'share-weibo':
                    window.open(`https://service.weibo.com/share/share.php?url=${encodeURIComponent(articleUrl)}&title=${encodeURIComponent(articleTitle)}`, '_blank');
                    break;
                    
                case 'share-twitter':
                    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(articleTitle)}&url=${encodeURIComponent(articleUrl)}`, '_blank');
                    break;
                    
                case 'share-facebook':
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(articleUrl)}`, '_blank');
                    break;
            }
            
            closeSharePanel();
        });
    });
});