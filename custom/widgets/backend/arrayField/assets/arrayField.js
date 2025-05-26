/**
 * Module manages the fields for an attribute
 * 
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */

(function() {
    $('body').on('click', '.btn-add-array-field', function(e) {
        e.preventDefault();

        var $elem = $(this);
        var fieldname = $elem .data('name');
        addFields(fieldname);
        updateCounters(fieldname);
    });

    $('body').on('click', '.btn-remove-array-field', function(e) {
        e.preventDefault();

        var $elem = $(this);
        var fieldname = $elem.data('name');
        removeFields($elem);
        updateCounters(fieldname);
    });

    function addFields(fieldname) {
        var $list = $('#'+fieldname+'-list');
        var $template = $('#'+fieldname+'-template').clone();

        $template.find('[data-name]').each(function() {
            var $elem = $(this);
            var name = $elem.data('name');
            $elem.attr('name', name)
                .removeAttr('data-name');
        });
        $list.append( $template.html() );
    }

    function removeFields($elem) {
        $elem.closest('.row').remove();
    }

    function updateCounters(fieldname) {
        var $list = $('#'+fieldname+'-list');
        $list.find('.row').each(function(idx) {
            var $row = $(this), html;

            rememberFieldValues($row);
            html = $row.html().replace(/(\[.*?\])\[(\d+)\](\[.*?\])/g, '$1[' + idx + ']$3');
            $row.html(html);
        });
    }

    function rememberFieldValues($container) {
        $container.find('input').each(function(idx) {
            var $input = $(this);
            $input.attr('value', $input.val() );
        });
    }
})();