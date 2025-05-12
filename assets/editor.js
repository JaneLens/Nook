(function ($) {
    $.fn.extend({
        /* 按键盘实现插入内容 */
        shortcuts: function () {
            this.keydown(function (e) {
                var _this = $(this);
                e.stopPropagation();
                if (e.altKey) {
                    switch (e.keyCode) {
                        case 67:
                            _this.insertContent('[code]' + _this.selectionRange() + '[/code]');
                            break;
                    }
                }
            });
        },
        /* 插入内容 */
        insertContent: function (myValue, t) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd('character', wee + t);
                    t <= 0 ? sel.moveStart('character', wee - 2 * t - myValue.length) : sel.moveStart('character', wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            } else {
                this.value += myValue;
                this.focus();
            }
        },
        /* 选择 */
        selectionRange: function (start, end) {
            var str = '';
            var thisSrc = this[0];
            if (start === undefined) {
                if (/input|textarea/i.test(thisSrc.tagName) && /firefox/i.test(navigator.userAgent)) str = thisSrc.value.substring(thisSrc.selectionStart, thisSrc.selectionEnd);
                else if (document.selection) str = document.selection.createRange().text;
                else str = document.getSelection().toString();
            } else {
                if (!/input|textarea/.test(thisSrc.tagName.toLowerCase())) return false;
                end === undefined && (end = start);
                if (thisSrc.setSelectionRange) {
                    thisSrc.setSelectionRange(start, end);
                    this.focus();
                } else {
                    var range = thisSrc.createTextRange();
                    range.move('character', start);
                    range.moveEnd('character', end - start);
                    range.select();
                }
            }
            if (start === undefined) return str;
            else return this;
        }
    });
})(jQuery);

/* 新按钮 */
$(function() {
    const items = [
        {
            title: '删除线',
            id: 'wmd-strike',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M17.154 14c.23.516.346 1.09.346 1.72 0 1.342-.524 2.392-1.571 3.147C14.88 19.622 13.433 20 11.586 20c-1.64 0-3.263-.381-4.87-1.144V16.6c1.52.877 3.075 1.316 4.666 1.316 2.551 0 3.83-.732 3.839-2.197a2.21 2.21 0 0 0-.648-1.603l-.12-.117H3v-2h18v2h-3.846zm-4.078-3H7.629a4.086 4.086 0 0 1-.481-.522C6.716 9.92 6.5 9.246 6.5 8.452c0-1.236.466-2.287 1.397-3.153C8.83 4.433 10.271 4 12.222 4c1.471 0 2.879.328 4.222.984v2.152c-1.2-.687-2.515-1.03-3.946-1.03-2.48 0-3.719.782-3.719 2.346 0 .42.218.786.654 1.099.436.313.974.562 1.613.75.62.18 1.297.414 2.03.699z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '~~删除线内容~~'
        },
        {
            title: '下划线',
            id: 'wmd-underline',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '<u>下划线内容</u>'
        },
        {
            title: '短代码',
            id: 'wmd-short-code',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M24 12l-5.657 5.657-1.414-1.414L21.172 12l-4.243-4.243 1.414-1.414L24 12zM2.828 12l4.243 4.243-1.414 1.414L0 12l5.657-5.657L7.07 7.757 2.828 12zm6.96 9H7.66l6.552-18h2.128L9.788 21z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '`短代码`'
        },
        {
            title: '长代码',
            id: 'wmd-long-code',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 12l-7.071 7.071-1.414-1.414L8.172 12 2.515 6.343 3.929 4.93 11 12zm0 7h10v2H11v-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n```\n代码块\n```\n'
        },
        {
            title: '插入链接',
            id: 'wmd-addlink-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 1 0-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 0 1 9.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 1 0 7.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.415-7.071 7.07-1.415-1.414 7.071-7.07z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '[链接名称](链接地址)'
        },
        {
            title: 'Emoji表情',
            id: 'wmd-emoji',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-7h2a3 3 0 0 0 6 0h2a5 5 0 0 1-10 0zm1-2a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm8 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'origin_btn'
        },
        {
            title: '图片',
            id: 'wmd-addimage-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M4.828 21l-.02.02-.021-.02H2.992A.993.993 0 0 1 2 20.007V3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H4.828zM20 15V5H4v14L14 9l6 6zm0 2.828l-6-6L6.828 19H20v-1.172zM8 11a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '![图片描述](图片链接)'
        },
        {
            title: '哔哩视频',
            id: 'wmd-netease-music-button',
            svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9236"><path d="M931.314 858.548l-0.032-547.662 0.031-1.961c0.069-5.214 0.18-16.791-6.55-23.632-2.941-2.969-8.164-9.353-16.451-9.353H613.097l122.489-174.069c7.306-10.536 4.668-23.583-5.878-30.881-10.541-7.295-25.01-6.803-32.308 3.741l-140.777 201.21h-46.897c-1.327 0-2.757 0.626-4.383-0.236L257.162 145.053c-11.312-6.019-25.374-1.017-31.406 10.306-6.023 11.321-1.734 22.885 9.597 28.914l176.92 91.667H124.264c-15.969 0-31.593 18.715-31.593 34.718v545.707c0 16.002 15.625 30.833 31.593 30.833h61.479c3.053 16.166 13.506 40.374 22.83 50.064 12.982 13.506 30.132 20.661 45.859 20.661h0.035c17.992 0 36.987-8.015 50.818-22.833 8.916-9.542 19.096-31.725 22.722-47.892h368.611c3.045 16.166 13.506 40.374 22.821 50.064 12.991 13.506 30.141 20.661 45.859 20.661h0.062c17.973 0 36.96-8.015 50.792-22.833 8.914-9.542 19.096-31.725 22.729-47.892h69.432c8.286 0 13.509-4.439 16.451-7.41 6.73-6.835 6.619-16.016 6.55-21.24z m-651.489 51.089c-8.677 9.282-18.782 9.895-25.35 9.895h-0.009c-4.966 0-13.584-0.803-20.788-8.288-4.943-5.134-10.423-17.982-12.83-24.043h71.602c-2.843 6.062-8.008 17.493-12.625 22.436z m510.875-0.002c-8.677 9.283-18.783 9.896-25.34 9.896h-0.027c-4.966 0-13.576-0.803-20.792-8.289-4.932-5.134-10.411-17.981-12.808-24.043h71.59c-2.841 6.063-8.013 17.494-12.623 22.436z m103.176-59.818h-67.447c-1.132 0-2.315-0.359-3.513-0.359-1.227 0-2.424 0.359-3.583 0.359H716.249c-0.826 0-1.632-0.317-2.483-0.349-1.395-0.041-2.741 0.349-4.033 0.349H125.002V313.324H893.875v536.493h0.001z" fill="rgba(153,153,153,1)" p-id="9237"></path><path d="M837.595 401.868c0.902-3.673 3.509-13.054-2.539-20.73-3.743-4.784-8.851-8.204-15.305-8.204h-608.25c-11.596 0-31.94 10.126-31.94 29.194v371.638c0 22.404 21.187 27.555 31.94 27.555h608.25c6.014 0 11.627-1.191 15.344-5.699 6.388-7.749 2.531-16.312 1.552-21.276-0.111-0.65-2.379-0.77-2.383-0.77v0.095-0.095l2.002-370.442 1.329-1.266z m-40.713 361.059H223.037l0.049-357.662h573.796v357.662z" fill="rgba(153,153,153,1)" p-id="9238"></path><path d="M386.78 495.239l-116.833 55.875c-8.682 4.152-12.342 14.548-8.2 23.221 2.987 6.257 9.23 9.914 15.718 9.914 2.52 0 5.081-0.554 7.505-1.715l116.83-55.873c8.686-4.154 12.352-14.55 8.2-23.225-4.157-8.681-14.561-12.38-23.22-8.197zM751.706 561.402l-129.164-79.094c-8.183-5.019-18.92-2.454-23.955 5.76-5.019 8.199-2.45 18.922 5.769 23.944l129.166 79.1a17.34 17.34 0 0 0 9.066 2.562c5.878 0 11.595-2.953 14.885-8.322 5.018-8.204 2.441-18.926-5.767-23.95zM630.078 616.894c-9.63 0-17.414 7.796-17.414 17.413 0 27.123-17.429 57.328-42.42 57.328-17.924 0-34.062-22.457-39.992-42.523-1.546-5.245-2.44-10.33-2.44-14.805 0-9.003-6.856-16.324-15.618-17.234-8.779 0.91-15.636 8.232-15.636 17.234 0 5.22-0.664 10.532-1.871 15.736-5.123 21.876-20.366 41.594-40.552 41.594-22.603 0-42.423-35.727-42.423-57.328 0-9.617-7.801-17.413-17.422-17.413-9.611 0-17.413 7.796-17.413 17.413 0 36.691 30.811 92.16 77.258 92.16 25.604 0 45.91-13.835 59.292-33.457 13.549 18.999 33.132 33.457 56.816 33.457 47.712 0 77.255-47.836 77.255-92.16 0.001-9.617-7.792-17.415-17.42-17.415z" fill="rgba(153,153,153,1)" p-id="9239"></path></svg>',
            type: 'wmd-button',
            text: '\n{bd-video}bvid{/bd-video}\n'
        },
        {
            title: '视频',
            id: 'wmd-video-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM8 5v14h8V5H8zM4 5v2h2V5H4zm14 0v2h2V5h-2zM4 9v2h2V9H4zm14 0v2h2V9h-2zM4 13v2h2v-2H4zm14 0v2h2v-2h-2zM4 17v2h2v-2H4zm14 0v2h2v-2h-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n{local-video}本地视频链接{/local-video}\n'
        },
        {
            title: '外链卡片',
            id: 'wmd-video-button',
            svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="12525"><path d="M631.296 887.296H189.952c-8.704 0-15.36-6.656-15.36-15.36V386.56c0-111.104 90.624-201.728 201.728-201.728h441.344c8.704 0 15.36 6.656 15.36 15.36V686.08c-0.512 111.616-91.136 201.216-201.728 201.216z m-425.472-30.72h425.472c93.696 0 170.496-76.288 171.008-170.496V215.552H376.832c-94.208 0-171.008 76.288-171.008 171.008v470.016zM640 400.384c-13.312-13.312-31.232-20.992-50.176-20.992s-36.864 7.168-50.176 20.992L484.864 454.656c-5.632 5.632-5.632 14.336 0 19.968s14.336 5.632 19.968 0L559.616 419.84c8.192-8.192 18.944-12.288 30.208-12.288s22.016 4.608 30.208 12.288c8.192 8.192 12.288 18.944 12.288 30.208s-4.608 22.016-12.288 30.208l-65.024 65.024c-16.384 16.384-43.52 16.384-60.416 0-5.632-5.632-14.336-5.632-19.968 0s-5.632 14.336 0 19.968c13.312 13.312 31.232 20.992 50.176 20.992 18.944 0 36.864-7.168 50.176-20.992L640 500.736c27.648-27.648 27.648-72.704 0-100.352zM502.784 597.504l-54.784 54.784c-8.192 8.192-18.944 12.288-30.208 12.288s-22.016-4.608-30.208-12.288c-8.192-8.192-12.288-18.944-12.288-30.208s4.608-22.016 12.288-30.208L452.608 527.36c16.384-16.384 43.52-16.384 60.416 0 5.632 5.632 14.336 5.632 19.968 0 2.56-2.56 4.096-6.144 4.096-10.24 0-3.584-1.536-7.168-4.096-10.24-13.312-13.312-31.232-20.992-50.176-20.992s-36.864 7.168-50.176 20.992l-65.024 65.024c-13.312 13.312-20.992 31.232-20.992 50.176s7.168 36.864 20.992 50.176c13.312 13.312 31.232 20.992 50.176 20.992 18.944 0 36.864-7.168 50.176-20.992l54.784-54.784c5.632-5.632 5.632-14.336 0-19.968-5.12-5.632-14.336-5.632-19.968 0z" p-id="12526" fill="rgba(153,153,153,1)"></path></svg>',
            type: 'wmd-button',
            text: '\n{link-card url="链接地址" title="示例网站" image="图片链接"}这是一个示例网站的描述{/link-card}\n'
        }
    ];
    
    items.forEach(_ => {
        let item = $(`<li class="${_.type}" id="${_.id}" title="${_.title}">${_.svg}</li>`);
        item.on('click', function () {
            if(_.type == 'wmd-button'){
                $('#text').insertContent(_.text);
            }
        });
        $('#wmd-button-row').append(item);
    });
});

/* 添加Emoji表情面板 */
$(function() {
    $('#wmd-button-row').append('<hr id="emojistart" style="border: unset;">');
    var emojiall = "😀 😁 😂 😃 😄 😅 😆 😉 😊 😋 😎 😍 😘 😗 😙 😚 😇 😐 😑 😶 😏 😣 😥 😮 😯 😪 😫 😴 😌 😛 😜 😝 😒 😓 😔 😕 😲 😷 😖 😞 😟 😤 😢 😭 😦 😧 😨 😬 😰 😱 😳 😵 😡 😠";
    var emojiarr = emojiall.split(" ");
    var emoji = "<div class='emojiblock' style='display:none;'>";
        emojiarr.forEach(function(element) {
            emoji += "<span class='editor_emoji'>" + element + "</span>";
        });
    emoji += "</div>";
    $('#emojistart').after(emoji);
});

$(document).on('click', '.editor_emoji',function () {
    var emoji = $(this).text();
    $('#wmd-editarea textarea').insertContent(emoji);
    $('#wmd-editarea textarea').focus();
});

window.onload = function () {
    /* Emoji表情 */
    $(document).on('click', '#wmd-emoji', function() {
        $('.emojiblock').slideToggle();
    });
    
    /* 插入表格 */
    $(document).on('click', '#wmd-table-button', function() {
        $('body').append(
            '<div id="postPanel">'+
            '<div class="wmd-prompt-background" style="position: fixed; top: 0px; z-index: 1000; opacity: 0.5; height: 100%; left: 0px; width: 100%;"></div>'+
            '<div class="wmd-prompt-dialog">'+
            '<div>'+
            '<h3><label class="typecho-label">插入表格</label></h3>'+
                '<label>表格行</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="A">'+
                '<label>表格列</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="B">'+
            '</div>'+
            '<form>'+
            '<button type="button" class="btn btn-s primary" id="wmd-table-button_ok">确定</button>'+
            '<button type="button" class="btn btn-s" id="post_cancel">取消</button>'+
            '</form>'+
            '</div>'+
            '</div>');
    });
    
    $(document).on('click', '#wmd-table-button_ok',function () {
        let row = $(".wmd-prompt-dialog input[name='A']").val();
        let column = $(".wmd-prompt-dialog input[name='B']").val();
        if (isNaN(row)) row = 3;
        if (isNaN(column)) column = 3;
        let rowStr = '';
        let rangeStr = '';
        let columnlStr = '';
        for (let i = 0; i < column; i++) {
            rowStr += '| 表头 ';
            rangeStr += '| ---- ';
        }
        for (let i = 0; i < row; i++) {
            for (let j = 0; j < column; j++) columnlStr += '| 内容 ';
            columnlStr += '|\n';
        }
        const textContent = `${rowStr}|\n${rangeStr}|\n${columnlStr}\n`;
        $('#text').insertContent(textContent);
        $('#postPanel').remove();
        $('#wmd-editarea textarea').focus();
    });
    
    /* 取消 */
    $(document).on('click','#post_cancel',function() {
        $('#postPanel').remove();
        $('#wmd-editarea textarea').focus();
    });
};