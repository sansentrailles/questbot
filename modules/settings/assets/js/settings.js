$(document).ready(function () {
    // $('.iframe-btn').fancybox({
    //     'width': 900,
    //     'height': 600,
    //     'type': 'iframe',
    //     'autoScale': false
    // });

    $('.iframe-btn').fancybox();

    // $('body').on('click', '.iframe-btn', function (e) {
    // });

    $('body').on('click', '[data-add-item]', function (e) {
        var id = $(this).data('id');
        var name = $(this).data('name');
        addBlock(id, name, index);
    });

    $('body').on('click', '[data-add-field-value]', function (e) {
        e.preventDefault();
        addFieldValue();
    });

    $('body').on('click', '[data-remove-field-value]', function (e) {
        e.preventDefault();
        removeValue($(this), 'value-item');
    });

    $('body').on('click', '[data-create-and-edit]', function (e) {
        e.preventDefault();
        var saveEditField = document.querySelector('[data-edit-field]');
        var form = saveEditField.closest('form');
        saveEditField.value = 1;
        form.submit();

    });

});

var removeValue = function(object, parent) {
    var container = object.closest('.'+parent);
    console.log(container);
    var list = $(".list-values");
    var settingId = list.data('setting-id');
    var index = container.data('index');

    var textarea = container.find('textarea');

    $.post('/admin/settings/default/remove-field', {
        index: index,
        settingId: settingId
    }, function (data) {
        if (data.status == 'ok') {
            if(textarea.length && typeof tinymce != 'undefined') {
                var id = textarea.attr('id')
                tinymce.EditorManager.execCommand('mceRemoveEditor', true, id);
            }

            container.remove();
        }
    });
};

var addFieldValue = function () {
    var list = $(".list-values");
    var last = list.find(".value-item:last");
    var index = parseInt(last.data('index'));
    var type = $('#setting-type').val();
    var settingId = list.data('setting-id');

    $.post('/admin/settings/default/add-field', {
        index: index,
        type: type,
        settingId: settingId
    }, function (data) {
        if (data.status == 'ok') {
            var item = $(data.html);
            var formControl = item.find('.form-control');
            var textArea = item.find('textarea');
            list.append(item);

                        // var name = formControl.attr('name');
                        var id = formControl.attr('id');
                        // $("#setting-form").yiiActiveForm("add", {
                        //     id: id,
                        //     name: name,
                        //     container: ".list-values",
                        //     input: "#" + id,
                        //     error: ".help-block",
                        //     value: 'ivanov@gmail.com'
                        // });


            var id = formControl.attr('id');
            if(textArea.length  && typeof tinymce != undefined) {
                id = textArea.attr('id');
                tinymce.EditorManager.execCommand('mceRemoveEditor', true, id);
                tinymce.EditorManager.execCommand('mceAddEditor', true, id);
            }
        }
    });

};

var addField = function() {
    var list = $('.list-values');
    var template = $('.field-template');
    var last = list.find('.value-item:last');
    var index = parseInt(last.data('index'));
    var formInput = template.find(".input-item");

    ++index;
    var inputName = formInput.data("name");
    var id = formInput.attr('id');

    var regex = /\{\{index\}\}/gi;
    inputName = inputName.replace(regex, index);
    id = id.replace(regex, index);

    formInput.attr("name", inputName).removeAttr("data-name");
    var templateHtml = template.html();

    var inputItem = templateHtml.replace(regex, index);

    list.append(inputItem);
    // $("#setting-form").yiiActiveForm("add", {
    //     id: id,
    //     name: inputName,
    //     container: ".list-values",
    //     input: "#" + id,
    //     error: ".help-block"
    // });

    // $('#setting-form').yiiActiveForm('validateAttribute', id);
};

        var addBlock = function(id, name) {
            var templateBlock = $('#'+id+'-template');
            var listContainer = $('#'+id+'-list');

            templateBlock.find('.input-field').attr('name', name).removeClass('input-field').html();
            listContainer.append(templateBlock.html());
        };

// var removeBlock = function(obj) {
//     $(obj).closest('.form-group').remove();
// };

// // remove below code
// function addField(fieldname) {
//     var list = $('#' + fieldname + '-list');
//     var html = $('#' + fieldname + '-etalon').html();

//     html = html.replace(/etalon\-/g, "");
//     list.append(html);
// }

// function removeBlock(obj) {
//     $(obj).closest('.form-group').remove();
// }

window.reinitTiny = function () {
    var editors = window.tinyMCE.editors;
    for (var i = 0; i < editors.length; i++) {
        editors[i].settings.file_browser_callback = function (field_name, url, type, win) {
            func_value = win.document.getElementById(field_name).value;
            filemanager(field_name, func_value, type, win);
        };
    }
};

function filemanager(id, value, type, win) {
    console.log(id, value, type, win);
    e = tinymce.activeEditor;
    t = id;
    a = type;
    s = win;

    var r = window.innerWidth - 30,
        g = window.innerHeight - 60;
    if (r > 1800 && (r = 1800), g > 1200 && (g = 1200), r > 600) {
        var d = (r - 20) % 138;
        r = r - d + 10;
    }
    urltype = 2, "image" == a && (urltype = 1), "media" == a && (urltype = 3);
    var o = "RESPONSIVE FileManager";
    "undefined" != typeof e.settings.filemanager_title && e.settings.filemanager_title && (o = e.settings.filemanager_title);
    var l = "key";
    "undefined" != typeof e.settings.filemanager_access_key && e.settings.filemanager_access_key && (l = e.settings.filemanager_access_key);
    var f = "";
    "undefined" != typeof e.settings.filemanager_sort_by && e.settings.filemanager_sort_by && (f = "&sort_by=" + e.settings.filemanager_sort_by);
    var m = "false";
    "undefined" != typeof e.settings.filemanager_descending && e.settings.filemanager_descending && (m = e.settings.filemanager_descending);
    var c = "";
    "undefined" != typeof e.settings.filemanager_subfolder && e.settings.filemanager_subfolder && (c = "&fldr=" + e.settings.filemanager_subfolder);
    var v = "";
    "undefined" != typeof e.settings.filemanager_crossdomain && e.settings.filemanager_crossdomain && (v = "&crossdomain=1", window.addEventListener ? window.addEventListener("message", n, !1) : window.attachEvent("onmessage", n)),
        tinymce.activeEditor.windowManager.open({
            title: o,
            file: e.settings.external_filemanager_path + "dialog.php?type=" + urltype + "&descending=" + m + f + c + v + "&lang=" + e.settings.language + "&akey=" + l,
            width: r,
            height: g,
            resizable: !0,
            maximizable: !0,
            inline: 1
        }, {
            setUrl: function (n) {
                //console.log(t);
                var i = s.document.getElementById(t);
                if (i.value = e.convertURL(n), "createEvent" in document) {
                    var a = document.createEvent("HTMLEvents");
                    a.initEvent("change", !1, !0), i.dispatchEvent(a)
                } else i.fireEvent("onchange")
            }
        });
}

function responsive_filemanager_callback(field_id)
{
    var $field = $('#' + field_id);
    var value = $field.val();
    $field.val('/files/static/' + value);
}
