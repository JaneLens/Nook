<?php

require_once("phpmailer.php");
require_once("smtp.php");

/* 邮件通知 */
if (
  Helper::options()->CommentMail === 'on' &&  //是否开启评论邮件通知
  Helper::options()->CommentMailHost &&  //邮箱服务器地址
  Helper::options()->CommentMailPort &&  //服务器端口号
  Helper::options()->CommentMailFromName &&  //发件人昵称
  Helper::options()->CommentMailAccount &&  //发件人邮箱
  Helper::options()->CommentMailPassword &&  //邮箱授权码
  Helper::options()->CommentSMTPSecure  //加密方式
) {
  Typecho_Plugin::factory('Widget_Feedback')->finishComment = array('Email', 'send');
}

class Email
{
    // 发送邮件的静态方法，接收评论数据作为参数
    public static function send($comment)
    {
        // 创建 PHPMailer 实例
        $mail = new PHPMailer(true);

        // 配置 SMTP 参数
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = Helper::options()->CommentSMTPSecure;
        $mail->Host = Helper::options()->CommentMailHost;
        $mail->Port = Helper::options()->CommentMailPort;
        $mail->FromName = Helper::options()->CommentMailFromName;
        $mail->Username = Helper::options()->CommentMailAccount;
        $mail->From = Helper::options()->CommentMailAccount;
        $mail->Password = Helper::options()->CommentMailPassword;
        $mail->isHTML(true);

        // 获取评论的文本内容并解析
        $text = $comment->text;
        $text = self::parseContent($text);

        // 根据评论类型选择邮件模板
        if ($comment->parent == 0) {
            // 直接发表的评论，发送给博主
            $html = self::getMailTemplateForNewComment($comment);
            $subject = '您的文章 [' . $comment->title . '] 收到一条新的评论！';
            $recipient = self::getAuthorEmail($comment->ownerId);
        } else {
            // 回复别人的评论，发送给被回复者
            $html = self::getMailTemplateForReply($comment);
            $subject = '您在 [' . $comment->title . '] 的评论有了新的回复！';
            $recipient = self::getParentEmail($comment->parent);
        }

        // 替换模板中的占位符
        $html = strtr($html, [
            "{{post_title}}" => $comment->title,
            "{{comment_content}}" => $text,
            "{{comment_author}}" => $comment->author,
            "{{comment_link}}" => $comment->permalink,
            "{{current_time}}" => date("Y-m-d H:i:s"),
            "{{unsubscribe_link}}" => "https://example.com/unsubscribe", // 替换为实际的退订链接
            "{{parent_comment}}" => self::getParentComment($comment->parent),
            "{{parent_author}}" => self::getParentAuthor($comment->parent)
        ]);

        // 设置邮件主题和收件人
        if ($recipient) {
            $mail->Body = $html;
            $mail->addAddress($recipient);
            $mail->Subject = $subject;
            $mail->send();
        }
    }

    // 解析评论内容
    private static function parseContent($text)
    {
        // 图片解析，格式为 ![名字](链接)
        $text = preg_replace('/!\[([^\]]*)\]\(([^\)]*)\)/', '<img style="max-width: 100%;vertical-align: middle;" src="$2" alt="$1"/>', $text);

        // 代码解析，格式为 ```代码类型```
        $text = preg_replace('/```([^\n]*)```/s', '<pre><code class="$1">$1</code></pre>', $text);

        // 链接解析，格式为 [超链接名字](链接)
        $text = preg_replace('/\[([^\]]*)\]\(([^\)]*)\)/', '<a href="$2" target="_blank" style="color: #12addb;text-decoration: none;">$1</a>', $text);

        return $text;
    }

    // 获取收到评论的邮件模板
    private static function getMailTemplateForNewComment($comment)
    {
        return '
        <div style="font-family: LXGW WenKai, Microsoft YaHei, sans-serif; max-width: 580px; margin: 0 auto; color: #555;">
        <!-- 信笺抬头 -->
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="display: inline-block; padding: 8px 0; color: #D4A5A5; font-size: 18px;">
                🌸 字里行间的回音
            </div>
            <div style="height:1px; background: linear-gradient(90deg, #f8f3f0, #D4A5A5, #f8f3f0); margin: 10px 28%;"></div>
        </div>
    
        <!-- 信纸正文 -->
        <div style="background: #FFFEFC; padding: 22px; border-radius: 6px; margin-bottom: 18px; border: 1px solid #F0E6E6;">
            <p style="margin:0 0 14px 0; line-height: 1.6;">
                亲爱的管理员：
            </p>
    
            <p style="margin:12px 0; color: #555;">
                你在 <span style="color:#C4A5A5; border-bottom:1px dotted #E0D0D0;">《{{post_title}}》</span> 
                种下的文字，开出了新的花朵：
            </p>
    
            <!-- 评论内容 -->
            <div style="background: white; padding: 14px; margin: 16px 0; border-radius: 4px; border-left: 2px solid #C4A5A5; box-shadow: 0 1px 3px rgba(196, 165, 165, 0.1);">
                <div style="line-height: 1.7; color: #495057;">
                    {{comment_content}}
                </div>
                <p style="margin:8px 0 0; text-align: right; color: #C4A5A5; font-size: 13px;">
                    🌿 {{comment_author}} 轻轻留下足迹
                </p>
            </div>
    
            <!-- 查看按钮 -->
            <div style="text-align: center; margin: 22px 0 12px;">
                <a href="{{comment_link}}" 
                   style="display: inline-block; padding: 8px 20px; background: #F0E6E6; color: #8B7D7D !important; text-decoration: none; border-radius: 4px; border: 1px dashed #D4A5A5; transition: all 0.3s;">
                    轻抚这片花瓣
                </a>
            </div>
        </div>
    
        <!-- 页脚 -->
        <div style="font-size: 12px; color: #A8A8A8; text-align: center; padding-top: 12px; border-top: 1px dashed #F0E6E6; line-height: 1.6;">
            <p>📅 这缕回响于 {{current_time}} 轻轻抵达</p>
            <p>📖
                <a href="//amrx.me" style="color: #C4A5A5; text-decoration: none;">
                    回到文字的小园
                </a> 
            </p>
            <div style="margin-top: 14px; font-size: 13px; color: #B8B8B8;">
                <p>每个字句都在等待懂它的眼睛</p>
            </div>
        </div>
    </div>
       ';
    }

    // 获取新的回复的邮件模板
    private static function getMailTemplateForReply($comment)
    {
        return '
        <div style="font-family: LXGW WenKai, Microsoft YaHei, sans-serif; max-width: 600px; margin: 0 auto; color: #555;">
            <!-- 信笺抬头 -->
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="display: inline-block; padding: 6px 0; color: #D4A5A5; font-size: 18px;">
                    🌸 字里相逢
                </div>
                <div style="height:1px; background: linear-gradient(90deg, #f8f3f0, #D4A5A5, #f8f3f0); margin: 12px 25%;"></div>
            </div>
        
            <!-- 信纸正文 -->
            <div style="background: #FFFEFC; padding: 24px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #F0E6E6;">
                <p style="margin:0 0 12px 0; color: #555; line-height: 1.6;">
                    亲爱的 {{parent_author}}：
                </p>
        
                <p style="margin:12px 0; color: #555;">
                    你在 <span style="color:#C4A5A5; border-bottom:1px dotted #E0D0D0;">《{{post_title}}》</span> 
                    种下的思绪，开出了新的枝芽：
                </p>
        
                <!-- 原留言 -->
                <div style="background: #FAF8F5; padding: 12px; margin: 16px 0; border-radius: 6px; border-left: 2px solid #E0D0D0;">
                    <div style="color: #666; line-height: 1.7;">
                        {{parent_comment}}
                    </div>
                    <p style="margin:6px 0 0; text-align: right; color: #A8A8A8; font-size: 12px;">
                        🍃 你留下的种子
                    </p>
                </div>
        
                <!-- 新回应 -->
                <div style="background: white; padding: 14px; margin: 16px 0; border-radius: 6px; border-left: 2px solid #C4A5A5; box-shadow: 0 1px 4px rgba(196, 165, 165, 0.1);">
                    <div style="color: #495057; line-height: 1.7;">
                        {{comment_content}}
                    </div>
                    <p style="margin:8px 0 0; text-align: right; color: #C4A5A5; font-size: 13px;">
                        🌱 {{parent_author}} 轻轻浇灌
                    </p>
                </div>
                
                <!-- 查看按钮 -->
                <div style="text-align: center; margin: 22px 0 12px;">
                    <a href="{{comment_link}}" 
                       style="display: inline-block; padding: 8px 20px;
                              background: #F0E6E6; color: #8B7D7D !important; 
                              text-decoration: none; border-radius: 4px;
                              border: 1px dashed #D4A5A5; transition: all 0.3s;">
                        轻抚这片新叶
                    </a>
                </div>
            </div>
        
            <!-- 页脚 -->
            <div style="font-size: 12px; color: #A8A8A8; text-align: center;
                      padding-top: 12px; border-top: 1px dashed #F0E6E6;
                      line-height: 1.6;">
                <p>📅 此信件于 {{current_time}} 轻轻折好</p>
                <p>📮
                    <a href="//amrx.me" style="color: #C4A5A5; text-decoration: none;">
                        回到文字的花园
                    </a> 
                </p>
                <div style="margin-top: 14px; font-size: 13px; color: #B8B8B8;">
                    <p>字句会泛黄，但相遇的温度常在</p>
                </div>
            </div>
        </div>
       ';
    }

    // 获取博主邮箱
    private static function getAuthorEmail($ownerId)
    {
        $db = Typecho_Db::get();
        $authoInfo = $db->fetchRow($db->select()->from('table.users')->where('uid =?', $ownerId));
        return $authoInfo['mail'] ?? null;
    }

    // 获取被回复者的邮箱
    private static function getParentEmail($parentId)
    {
        $db = Typecho_Db::get();
        $parentInfo = $db->fetchRow($db->select('mail')->from('table.comments')->where('coid =?', $parentId));
        return $parentInfo['mail'] ?? null;
    }

    // 获取被回复的评论内容
    private static function getParentComment($parentId)
    {
        $db = Typecho_Db::get();
        $parentInfo = $db->fetchRow($db->select('text')->from('table.comments')->where('coid =?', $parentId));
        return $parentInfo['text'] ?? '未知评论';
    }

    // 获取被回复者的用户名
    private static function getParentAuthor($parentId)
    {
        $db = Typecho_Db::get();
        $parentInfo = $db->fetchRow($db->select('author')->from('table.comments')->where('coid =?', $parentId));
        return $parentInfo['author'] ?? '未知用户';
    }
}
