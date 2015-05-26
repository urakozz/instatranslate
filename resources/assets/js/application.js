/**
 * Created by yury on 26/05/15.
 */

if (typeof jQuery === 'undefined') {
    throw new Error('Requires jQuery')
}

+function ($) {
    'use strict';
    var version = $.fn.jquery.split(' ')[0].split('.');
    if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
        throw new Error('jQuery version should be  1.9.1 or higher')
    }
}(jQuery);

+function ($) {
    'use strict';

    $('.it-post-comment').on('click', function () {
        var translatable = $(this).parent(".translatable");
        var source = translatable.find(".translatable__source");
        var translation = translatable.find(".translatable__translation");

        if (translatable.hasClass('translatable_translated_yes')) {
            return;
        }
        if (translatable.hasClass('translatable_translated_pending')) {
            return;
        }

        translatable.addClass("translatable_translated_pending");
        $.ajax({
            url: "/api/v1/translate/" + source.data('mediaid'),
            data: {userid: source.data('userid')},
            method: "GET",
            dataType: "json"
        }).done(function (data) {

            console.log(data);
            if (data.translation) {

                translatable.removeClass("translatable_translated_no");
                translatable.addClass("translatable_translated_yes");

                var span = translation.find(".it-post-comment-text");
                span.text(data.translation);
            }
        }).always(function () {
            translatable.removeClass("translatable_translated_pending");
        });
    });
}(jQuery);

