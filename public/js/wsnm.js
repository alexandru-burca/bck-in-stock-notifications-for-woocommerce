jQuery(document).ready(function($) {

    // -----------------------------------------------------------------------
    // Event delegation: catches both statically rendered and JS-injected CTAs.
    // -----------------------------------------------------------------------
    $(document).on('click', '.wsnm-cta', wsnm_button_click);

    // -----------------------------------------------------------------------
    // Core popup handler
    // -----------------------------------------------------------------------
    function wsnm_button_click() {
        var $cta = $(this);
        if ($cta.hasClass('wsnm-waiting')) return;

        var product_id   = $cta.data('product');
        var variation_id = $cta.data('variation') || '';
        var nonce        = $cta.data('nonce');

        var data = {
            action:    'wsnm_open_popup',
            product:   product_id,
            variation: variation_id,
            nonce:     nonce
        };

        $cta.addClass('wsnm-waiting').prop('disabled', true);
        $cta.append('<span class="wsnm-spinner"></span>');

        $.post(ajax_object.ajax_url, data, function(response) {
            $cta.removeClass('wsnm-waiting').prop('disabled', false);
            $('.wsnm-spinner').remove();

            if (!response.error) {
                $('body').append(response.content);

                $('#wsnm-submit-form').on('click touch', function() {
                    $('#wsnm-out-of-stock-form').trigger('submit');
                });

                if (response.recaptcha_status) {
                    grecaptcha.render('ligh-recaptcha-id', {
                        sitekey: response.recaptcha_key
                    });
                }

                $('#wsnm-out-of-stock-form').on('submit', function(e) {
                    e.preventDefault();
                    if ($('#wsnm-submit-form').hasClass('wsnm-waiting')) return;

                    var recaptcha  = $('textarea[name=g-recaptcha-response]').val() || '';
                    var first_name = $('input[name=wsnm_form_first_name]').val() || '';
                    var last_name  = $('input[name=wsnm_form_last_name]').val() || '';

                    var formData = {
                        action:     'wsnm_save_request',
                        first_name: first_name,
                        last_name:  last_name,
                        email:      $('input[name=wsnm_form_email]').val(),
                        product:    product_id,
                        variation:  variation_id,
                        recaptcha:  recaptcha,
                        nonce:      $('input[name=wsnm_add_request_field]').val()
                    };

                    $('#wsnm-submit-form').addClass('wsnm-waiting');
                    $('#wsnm-submit-form').append('<span class="wsnm-spinner"></span>');

                    $.post(ajax_object.ajax_url, formData, function(response) {
                        $('#wsnm-submit-form').removeClass('wsnm-waiting');
                        $('.wsnm-spinner').remove();

                        if (response.status) {
                            $('#wsnm-modal .wsnm-modal-body').html(response.message);
                            setTimeout(function() {
                                $('#wsnm-modal').remove();
                            }, 3000);
                        } else {
                            $('#wsnm-ajax-response').text(response.message);
                            if (typeof grecaptcha !== 'undefined') {
                                grecaptcha.reset();
                            }
                            if (response.code === 'recaptcha-issue') {
                                $('#ligh-recaptcha-id').css({
                                    'border-color': 'red',
                                    'border-style': 'solid',
                                    'border-width': '1px'
                                });
                            }
                        }
                    });
                });
            }

            $('.wsnm-modal-close').on('click', function() {
                $('#wsnm-modal').remove();
            });
        });
    }

    // -----------------------------------------------------------------------
    // Close modal on backdrop click
    // -----------------------------------------------------------------------
    $(window).on('click', function(e) {
        if (e.target.id === 'wsnm-modal') {
            $('#wsnm-modal').remove();
        }
    });

});
