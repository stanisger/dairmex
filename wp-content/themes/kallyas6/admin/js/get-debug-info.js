jQuery(function($)
{
    "use strict";
    //@see: zn-debug-ajax-js
    if(typeof(window.ZnDebugInfo) == 'undefined'){
        alert('Kallyas: Application error [ZnDebugInfoAjax]. Please contact the theme developer about this issue!');
        return;
    }

    var znDebug = window.ZnDebugInfo;

    $('#zn_debug_info_btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var nonce = $(this).data('nonce');

        if(!nonce || nonce.length < 1){
            alert(znDebug.nonceMissing);
            return;
        }

        var data = {
            'dbg_nonce' : nonce,
            'dbg_type'  : 'get_debug_info',
            'action' : znDebug.ajaxAction
        };

        $.ajax({
            url: ajaxurl,
            type : 'POST',
            cache: false, /* for IE8 */
            data: data,
            success: function(response) {
                if(response && response.length > 0){
                    $('#kzn_debug_info_data').val(response);
                }
            },
            fail: function() {
                alert(znDebug.failMessage);
            }
        });
    });
});
