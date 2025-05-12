<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/* 插件方法 */
require_once('core/factory.php');
// 季节函数
function get_current_season() {
    $month = date('n');
    if ($month >= 3 && $month <= 5) return '春';
    if ($month >= 6 && $month <= 8) return '夏';
    if ($month >= 9 && $month <= 11) return '秋';
    return '冬';
}
/* 时间更替（当年） ok */
function get_lastyear($date){
    $d = new Typecho_Date(Typecho_Date::gmtTime());
    $now = $d->format('Y-m-d H:i:s');
    $t = strtotime($now) - $date;
    
    $time_units = array(
        31536000 => ' 年',
        2592000 => ' 月',
        604800 => ' 周',
        86400 => ' 天',
        3600 => ' 小时',
        60 => ' 分钟',
        1 => ' 秒'
    );
    
    foreach ($time_units as $unit => $label) {
        if ($t >= $unit) {
            $value = floor($t / $unit);
            return $value . $label . ' 前';
        }
    }
}
function themeConfig($form)
{
    $Favicon = new Typecho_Widget_Helper_Form_Element_Textarea(
    'Favicon',
    NULL,
    NULL,
    '网站 Favicon 设置',
    '介绍：用于设置网站 Favicon，一个好的 Favicon 可以给用户一种很专业的观感 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费转换 Favicon 网站 <a target="_blank" href="//tool.lu/favicon">tool.lu/favicon</a>'
  );
  $form->addInput($Favicon);
  
  $CustomFont = new Typecho_Widget_Helper_Form_Element_Text(
    'CustomFont',
    NULL,
    NULL,
    '自定义网站字体（非必填）',
    '介绍：用于修改全站字体，填写则使用引入的字体，不填写使用默认字体 <br>
         格式：字体URL链接（推荐使用woff格式的字体，网页专用字体格式） <br>
         注意：字体文件一般有几兆，建议使用cdn链接'
  );
  $form->addInput($CustomFont);
  
  $Friends = new Typecho_Widget_Helper_Form_Element_Textarea(
    'Friends',
    NULL,
    NULL,
    '友情链接（非必填）',
    '介绍：用于填写友情链接 <br />
         注意：您需要先增加友链链接页面（新增独立页面-右侧模板选择友链），该项才会生效 <br />
         格式：博客名称 || 博客地址 || 博客头像 || 博客简介 <br />
         其他：一行一个，一行代表一个友链'
  );
  $form->addInput($Friends);
  $CommentMail = new Typecho_Widget_Helper_Form_Element_Select(
    'CommentMail',
    array('off' => '关闭（默认）', 'on' => '开启'),
    'off',
    '是否开启评论邮件通知',
    '介绍：开启后评论内容将会进行邮箱通知 <br />
         注意：此项需要您完整无错的填写下方的邮箱设置！！ <br />
         其他：下方例子以QQ邮箱为例，推荐使用QQ邮箱'
  );
  $form->addInput($CommentMail);

  $CommentMailHost = new Typecho_Widget_Helper_Form_Element_Text(
    'CommentMailHost',
    NULL,
    NULL,
    '邮箱服务器地址',
    '例如：smtp.qq.com'
  );
  $form->addInput($CommentMailHost);

  $CommentSMTPSecure = new Typecho_Widget_Helper_Form_Element_Select(
    'CommentSMTPSecure',
    array('ssl' => 'ssl（默认）', 'tsl' => 'tsl'),
    'ssl',
    '加密方式',
    '介绍：用于选择登录鉴权加密方式'
  );
  $form->addInput($CommentSMTPSecure);

  $CommentMailPort = new Typecho_Widget_Helper_Form_Element_Text(
    'CommentMailPort',
    NULL,
    NULL,
    '邮箱服务器端口号',
    '例如：465'
  );
  $form->addInput($CommentMailPort);

  $CommentMailFromName = new Typecho_Widget_Helper_Form_Element_Text(
    'CommentMailFromName',
    NULL,
    NULL,
    '发件人昵称',
    '例如：帅气的象拔蚌'
  );
  $form->addInput($CommentMailFromName);

  $CommentMailAccount = new Typecho_Widget_Helper_Form_Element_Text(
    'CommentMailAccount',
    NULL,
    NULL,
    '发件人邮箱',
    '例如：2323333339@qq.com'
  );
  $form->addInput($CommentMailAccount);

  $CommentMailPassword = new Typecho_Widget_Helper_Form_Element_Text(
    'CommentMailPassword',
    NULL,
    NULL,
    '邮箱授权码',
    '介绍：这里填写的是邮箱生成的授权码 <br>
         获取方式（以QQ邮箱为例）：<br>
         QQ邮箱 > 设置 > 账户 > IMAP/SMTP服务 > 开启 <br>
         其他：这个可以百度一下开启教程，有图文教程'
  );
  $form->addInput($CommentMailPassword);

}

function themeFields($layout) {
    ?>
    <?
    if($_SERVER['SCRIPT_NAME']=="/admin/write-post.php"){
        $article_type= new Typecho_Widget_Helper_Form_Element_Radio('article_type',array('say' => _t('动态'),'note' => _t('文章'),'books' => _t('书单')),'say',_t('文章类型'),_t("选择文章类型首页输出"));
        $layout->addItem($article_type);
    }
    if($_SERVER['SCRIPT_NAME']=="/admin/write-page.php"){
        $subtitle = new Typecho_Widget_Helper_Form_Element_Text('subtitle', NULL, NULL, _t('介绍'), _t('页面简介'));
        $layout->addItem($subtitle);
        $extra_content = new Typecho_Widget_Helper_Form_Element_Textarea('extra_content', NULL, NULL, _t('底部补充内容'), _t('正文内容结束之后内容，在页脚的上方显示'));
        $layout->addItem($extra_content);
    }
    $css = new Typecho_Widget_Helper_Form_Element_Textarea('css', NULL, NULL, _t('css设置'), _t('给当前页面添加新css内容'));
    $layout->addItem($css);
}
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');
class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/assets/option.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/assets/editor.js' . "'></script>";

    }
}
function check_XSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',  
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}

function reply($text,$word = true)
{
    if (check_XSS($text)) {
        $text = "该回复疑似异常，已被系统拦截！";
    }
    if($word == true){
        $text = strip_tags($text, "<img>");
    }else{
        $text = rtrim(strip_tags($text), "\n");
    }
    return $text;
}
function _article_changetext($post) {
    $content = $post->content;
    $cid = $post->cid;
    
    // 基本转换
    $content = strtr($content, array(
        "{x}" => '✅',
        "{ }" => '☑️'
    ));
    
    // 外链卡片处理 (新增)
    $content = preg_replace_callback(
        '/{link-card url="([^"]+)"(?: title="([^"]+)")?(?: image="([^"]+)")?}([^"]+){\/link-card}/',
        function($matches) {
            $url = htmlspecialchars($matches[1], ENT_QUOTES);
            $title = isset($matches[2]) ? htmlspecialchars($matches[2], ENT_QUOTES) : '外部链接';
            $image = isset($matches[3]) ? htmlspecialchars($matches[3], ENT_QUOTES) : '';
            $desc = isset($matches[4]) ? htmlspecialchars($matches[4], ENT_QUOTES) : '';
            
            $cardHtml = '<div class="link-card">';
            $cardHtml .= '<a href="'.$url.'" target="_blank" rel="noopener noreferrer">';
            
            if ($image) {
                $cardHtml .= '<div class="link-card-image">';
                $cardHtml .= '<img src="'._getLazyload().'" data-src="'.$image.'" alt="'.$title.'" class="lazyload">';
                $cardHtml .= '</div>';
            }
            
            $cardHtml .= '<div class="link-card-content">';
            $cardHtml.= '<div class="link-card-top">';
            $cardHtml .= '<h3>'.$title.'</h3>';
            $cardHtml .= '<span> | </span>';
            $cardHtml .= '<span class="link-card-url">'.parse_url($url, PHP_URL_HOST).'</span>';
            $cardHtml .= '</div>';
            if ($desc) {
                $cardHtml .= '<p>'.$desc.'</p>';
            }
            $cardHtml .= '</div>';
            $cardHtml .= '</a>';
            $cardHtml .= '</div>';
            
            return $cardHtml;
        },
        $content
    );
    
    // 图片懒加载处理
    $content = preg_replace(
        '/<img src([\s\S]*?)title="([\s\S]*?)">/', 
        '<span data-fancybox="gallery" data-caption="$2">'.
        '<img src="'._getLazyload().'" class="lazyload" data-src$1 alt="$2"></span>', 
        $content
    );
    
    // 移除不必要的p标签包裹
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);
    $content = preg_replace('/<p>\s*(<div class="link-card">[\s\S]*?<\/div>)\s*<\/p>/', '$1', $content);
    
    echo $content;
}

function _getAbstract($item, $num) {
    $abstract = "";
    
    if ($item->password) {
        $abstract = "⚠️此文章已加密";
    } else {
        if ($item->fields->post_abstract) {
            $abstract = $item->fields->post_abstract;
        } else {
            $abstract = strip_tags($item->excerpt);
            $abstract = preg_replace('/\-o\-/', '', $abstract);
            $abstract = preg_replace('/{[^{]+}/', '', $abstract);
        }
    }
    
    if ($abstract === '') {
        $abstract = "⚠️此文章暂无简介";
    }
    
    return mb_substr($abstract, 0, $num);
}
/* 获取全局懒加载图 ok */
function _getLazyload($type = true)
{
    return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}