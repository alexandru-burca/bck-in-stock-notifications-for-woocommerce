jQuery(document).ready(function($){
    //confirmation email
    $('input[name=wsnm_subscribe_confirmation_status]').on('change', function (){
        if(this.checked) {
            $('#wsnm_subscribe_confirmation_row').css('display', 'block');
        }else{
            $('#wsnm_subscribe_confirmation_row').css('display', 'none');
        }
    })
    //recaptcha
    $('input[name=wsnm_form_recaptcha_status]').on('change', function (){
        if(this.checked) {
            $('#wsnm_form_recaptcha').css('display', 'block');
        }else{
            $('#wsnm_form_recaptcha').css('display', 'none');
        }
    })

    //Pause notification - disable notice
    $('input[name=wsnm_product_pause]').on('change', function (){
        if(this.checked) {
            $('.wsnm-automatically-mode-enabled').addClass('wsnm-disable-me');
        }else{
            $('.wsnm-automatically-mode-enabled').removeClass('wsnm-disable-me');
        }
    })

    $('#wsnm_btn_background_color').wpColorPicker();
    $('#wsnm_btn_text_color').wpColorPicker();

    // HubSpot check connection
    $('#wsnm-hubspot-check').on('click', function() {
        var $btn    = $(this);
        var $result = $('#wsnm-hubspot-check-result');
        var token   = $('input[name="wsnm_hubspot_token"]').val();

        $btn.prop('disabled', true).text('Checking…');
        $result.hide().text('').css('color', '');

        $.post(ajaxurl, {
            action: 'wsnm_hubspot_check_connection',
            nonce:  wsnm_admin.hubspot_check_nonce,
            token:  token
        }, function(response) {
            $btn.prop('disabled', false).text('Check connection');
            $result.show();
            if (response.success) {
                $result.css('color', '#46b450').text(response.data.message);
            } else {
                $result.css('color', '#dc3232').text(response.data.message);
            }
        });
    });
})