<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="renderer" content="webkit" />
        <meta name="format-detection" content="email=no" />
        <meta name="format-detection" content="telephone=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
        <?php if ($this->options->Favicon()) : ?>
        <link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
        <?php else : ?>
        <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text x=%22-0.125em%22 y=%22.9em%22 font-size=%2290%22>🌈</text></svg>" />
        <?php endif; ?>
        <title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
        <?php if ($this->is('single')) : ?>
          <meta name="keywords" content="<?php echo (isset($this->fields->keywords) && $this->fields->keywords) ? $this->fields->keywords : htmlspecialchars($this->_keywords ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          <meta name="description" content="<?php echo (isset($this->fields->description) && $this->fields->description) ? $this->fields->description : htmlspecialchars($this->_description ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          <?php $this->header('keywords=&description='); ?>
        <?php else : ?>
          <?php $this->header(); ?>
        <?php endif; ?>
        
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/style/main.css'); ?>">
        
        <?php
            $fontUrl = $this->options->CustomFont ?? ''; // 使用空字符串作为默认值
            $fontFormat = '';
            
            if (strpos($fontUrl, 'woff2') !== false) {
                $fontFormat = 'woff2';
            } elseif (strpos($fontUrl, 'woff') !== false) {
                $fontFormat = 'woff';
            } elseif (strpos($fontUrl, 'ttf') !== false) {
                $fontFormat = 'truetype';
            } elseif (strpos($fontUrl, 'eot') !== false) {
                $fontFormat = 'embedded-opentype';
            } elseif (strpos($fontUrl, 'svg') !== false) {
                $fontFormat = 'svg';
            }
        ?>
        <style>
            @font-face {
                font-family: 'wodeziti';
                font-weight: 400;
                font-style: normal;
                font-display: swap;
                src: url('<?php echo $fontUrl ?>');
                <?php if ($fontFormat) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
                <?php endif; ?>
            }
            body {
                <?php if ($fontUrl) : ?>
                font-family: 'wodeziti';
                font-weight: 400;
                <?php endif; ?>
                }
            <?php if ($this->fields->css): ?> 
                <?php $this->fields->css(); ?>
            <?php endif;?>
        </style>

    </head>
    
    <body class="<?php if ($this->is('index')) ://判断首页 ?>home-page<?php endif; ?><?php if ($this->is('single')) ://判断为阅读页面page+post ?>single-page<?php endif; ?>">
        <div class="container">