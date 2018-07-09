jQuery(document).ready(function($) {

    //Js Handler Code For Overview page

    $overviewPage = ($('.product-info').length > 0) ? true : false;

    if ($overviewPage) {

        // Use Independent ajax variable for overview page not from localised plugin js object. 	
        var ajaxUrl = $('.product-info').data('ajaxurl');
        $('#user-suggestion,#purchase_code').keyup(function() {
            $(this).css('border', 'none');
        });

        $('#submit-user-suggestion').click(function() {

            if ($('#user-suggestion').val() == '') {
                $('#user-suggestion').css('border', '1px solid red');
                return false;
            } else {

                jQuery.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    data: {
                        action: 'submit_user_suggestion',
                        uss: $('#uss').val(),
                        suggestion: $('#user-suggestion').val(),
                        suggestionfor: $('.product-info').data('product-name')

                    },
                    beforeSend: function() {

                        $('.submitsuggestion').show();
                        $('#user-suggestion').css('border', 'none');
                    },

                    success: function(data) {

                        $('#user-suggestion').val('');
                        //console.log(data);
                        $('.submitsuggestion').hide();
                        $headericon = '<h1 class="green">Suggestion Box</h1><span name="user_sugg_status" class="greenbg" id="user_sugg_status"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Submitted</span>';
                        $('.user-suggestion-area').html($headericon);


                    }

                });

            }

        });


        $('#purchase-verification-btn').click(function() {

            if ($('#purchase_code').val() == '') {
                $('#purchase_code').css('border', '1px solid red');
                return false;
            } else {

                jQuery.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: ajaxUrl,
                    data: {
                        action: 'verify_envanto_purchase',
                        pvn: $('#pv-nonce').val(),
                        purchasekey: $('#purchase_code').val(),
                        current_text_domain: $('.product-info').data('current-product-slug')
                    },
                    beforeSend: function() {
                        $('.pm').remove();
                        $('#purchase-verification-btn').css('float', 'left');
                        $('.purchaseverificationcheck').show();
                    },
                    success: function(data) {
                        $('#next').remove();
                        $('#purchase-verification-btn').css('float', 'none');
                        $('.purchaseverificationcheck').hide();
                        //console.log(data);
                        if (data.purchase_verified == true) {

                            $message = '<div class="row brow p-verified"><div class="col-md-2"><i class="fa fa-check" aria-hidden="true"></i></div><div class="col-md-10"><strong>Purchased Verified</strong><br>You have verified your purchase with us.</div></div>';
                            $headericon = '<h1 class="green">Product Information</h1><span name="activation_status" class="greenbg" id="activation_status"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Verified</span>';
                            $('.product-activation-area').html($headericon);
                            $('.product-activation-area h1').css('width', '68%');
                            $('.verifiy-purchase-info').prepend($message);
                            $('#prev').trigger('click');

                        } else if (data.purchase_verified == 'false') {
                            $message = '<p class="pm purchase-not-verified alert-danger">' + data.error + '</p>';
                            $('#purchase-verification-form').prepend($message);
                        } else {
                            $message = '<p class="pm purchase-not-verified alert-danger">Please enter a valid purchase code.</p>';
                            $('#purchase-verification-form').prepend($message);
                        }


                    },
                    error: function(data, errorThrown) {
                        $('#purchase-verification-form').prepend('Sorry! Server cannot be reached right now');
                    }

                });


            }


        });

        function cmpVersions(a, b) {
            var i, diff;
            var regExStrip0 = /(\.0+)+$/;
            var segmentsA = a.replace(regExStrip0, '').split('.');
            var segmentsB = b.replace(regExStrip0, '').split('.');
            var l = Math.min(segmentsA.length, segmentsB.length);

            for (i = 0; i < l; i++) {
                diff = parseInt(segmentsA[i], 10) - parseInt(segmentsB[i], 10);
                if (diff) {
                    return diff;
                }
            }
            return segmentsA.length - segmentsB.length;
        }

        $('.check_for_updates_btn').click(function() {

            var current_version = $('.product-info').data('product-version');
            jQuery.ajax({
                type: "POST",
                url: ajaxUrl,
                data: {
                    action: 'check_products_updates',
                    productslug: $('.product-info').data('current-product-slug'),
                    current_text_domain: $('.product-info').data('current-product-slug')

                },
                dataType: 'json',
                beforeSend: function() {
                    $('.updatecheck').show();
                },
                success: function(data) {
                    console.log(data);
                    $('.updatecheck').hide();

                    var updateavailable = false;
                    $('.product-info h1.full').css('float', 'left');
                    if (data.status == '1') {
                        console.log(current_version + ' and ' + data.latestversion);
                        if (cmpVersions(current_version, data.latestversion) < 0)
                            updateavailable = true;

                    }
                    if (updateavailable) {

                        $('.latest_version_availalbe').html('Latest Version Available : <strong>' + data.latestversion + '</strong>');
                        var updated = '<a class="codecanyon-link" href="http://www.codecanyon.net/downloads" target="_blank"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;Update Available</a>';
                        $('#plugin_update_status').addClass('orangebg');


                    } else {

                        $('.latest_version_availalbe').html('Your installed version : ' + current_version);
                        var updated = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Plugin Up To Date';
                        $('#plugin_update_status').addClass('greenbg');
                    }

                    $('#plugin_update_status').html(updated);
                }

            });

        });


        $('#myCarousel').carousel({
            interval: 10000
        })

        $('.verifiy-purchase-form').hide();

        $('#hide_promotional_products').click(function() {

            // alert(wpp_js_lang.ajax_url);    
            jQuery.ajax({
                type: "POST",
                url: ajaxUrl,
                data: {
                    action: 'hide_promotional_products',
                    productname: $('.product-info').data('current-product')
                },
                beforeSend: function() {},
                success: function(data) {
                    $(".srow").hide(1000);
                    console.log(data);
                    /*
                     */

                }

            });

        });

        $("#next").click(function() {
            $('.verifiy-purchase-info').hide();
            $('.verifiy-purchase-form').show();
            $('#prev').show();
            $('#next').hide();
            return false;
        });

        $("#prev").click(function() {

            $('.verifiy-purchase-info').show();
            $('.verifiy-purchase-form').hide();
            $('#next').show();
            $('#prev').hide();
            return false;
        });

    }


});
