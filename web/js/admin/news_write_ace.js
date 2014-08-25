$(function(){
    $('textarea[data-editor]').each(function(){
        var textarea = $(this);
        var mode = textarea.data('editor') || 'html';
        var editorDiv = $('<div/>', { position: 'absolute', width: textarea.width(), height: 500, 'class': textarea.attr('class')}).insertBefore(textarea);
        textarea.css('display','none');
        var editor = ace.edit(editorDiv[0]);
        editor.getSession().setValue(textarea.val());
        editor.setTheme('ace/theme/merbivore');
        editor.getSession().setMode('ace/mode/'+mode);
        editor.getSession().setUseWrapMode(true);
        editor.getSession().setWrapLimitRange(80,80);
        editor.renderer.setPrintMarginColumn(80);
        editor.setOption('enableEmmet', true);
        editor.getSession().on('change', function(e){
            textarea.val(editor.getSession().getValue());
        });
    });
});
