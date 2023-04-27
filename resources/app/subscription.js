var subscription = (function ($, undefined) {

    var showOffer = function() {
        $('.modal-header').html('<h5 class="modal-title">Subscribe Today</h5>');
        $('.modal-header').append(modal_form.js_panel_control([
            {'title': 'Close', 'class': 'btn-secondary', 'id': 'control-cancel', 'icon':'far fa-times'},
        ]));
        $('.modal-body').html(offer_text);
        $('.modal-footer').html(modal_form.js_panel_action([
            {
                'label': 'Subscribe Now',
                'title': 'Subscribe Now',
                'button_class': 'btn-success m-1',
                'icon': 'fas fa-two-thumbs',
                'id': 'utility-advance',
                'action': 'collect_payment',
            }

        ]));
        if(!$('#myModal').is(':visible')) {
            $('#genericModal').modal('show');
        }

        utility.set_dynamic_button('#utility-advance', collectPayment);
        utility.set_dynamic_button('#control-cancel', hideModal);
    };

    var collectPayment = function() {
        $('.modal-body').html(payment_form);
        $('.modal-footer').html(modal_form.js_panel_action([
            {
                'label': 'Start My Subscription',
                'title': 'Start My Subscription',
                'button_class': 'btn-primary m-1',
                'icon': 'fas fa-credit-card',
                'id': 'utility-advance',
                'action': 'post_payment',
            }

        ]));
        initPaymentForm();
        utility.reset_dynamic_button('#utility-advance');
        utility.set_dynamic_button('#utility-advance', function() {
            $('.modal-body form').submit();
        });
    };

    var initPaymentForm = function() {
        $('.modal-body form').on('submit', function (e) {
            e.preventDefault();
            var data = $('form').serializeArray();
                    data.push({
                        name: "_token",
                        value: $("meta[name='csrf-token']").attr("content")
                    });

            $.ajax({
                url: '/subscription/new',
                cache: false,
                type: "POST",
                data: $.param(data),
                dataType: 'json'
            })
            .done(function (resp) {
                showThanks();
            })
            .fail(function (message) {
                utility.ajax_fail(message);
            });
        });
    };

    var showThanks = function() {
        $('.modal-body').html(complete_text);
        $('.modal-footer').html(modal_form.js_panel_action([
            {
                'label': 'Thank You',
                'title': 'Thank You',
                'button_class': 'btn-primary m-1',
                'icon': 'fas fa-hearts-face',
                'id': 'utility-advance',
                'action': 'reload-page',
            }

        ]));
        utility.reset_dynamic_button('#utility-advance');
        utility.set_dynamic_button('#utility-advance', hideModal);
    };

    var hideModal = function() {
        $('#genericModal').modal('hide');
        utility.reset_dynamic_button('#control-cancel');
        utility.reset_dynamic_button('#utility-advance');
        $('.modal-footer').html('');
        $('.modal-title').html('');
        $('.modal-header').html('');
    };


    var complete_text = "<p>Thanks for supporting Billminder, and safe,secure internet applications development. " +
    "Remember, our subscribers always get new features first, and some features remain exclusives!</p>";

    var offer_text = "<p>A subscription helps to fund continued development of Billminder.</p>" +
        "<p>We never have advertisers, and we don't allow user data access to anyone!</p>" +
        "<p>Subscribers always get new features first.</p>" +
        "<p>Some features will always be exclusive to subscribers</p>" +
        "<p>Upcoming Subscriber-Only Features include: <ul>" +
        "<li>downloadable reports</li>" +
        "<li>changable encryption keys for your personal data</li>" +
        "<li>access to your bank accounts for balance and autopay checks</li>" +
        "</ul></p>" +

        "<p>Currently, Subscription is only $30 US per year, and your subscription fee is guaranteed never to increase as long as you are are a subscriber.</p>" +
        "<p>Subscribe today!  Your subscription will be added to your billminder list, as well!</p>"
    ;

    var payment_form =  "<p>Billminder subscription is $30 per year.  This will be added to your billminder list, as well.</p>" +
    "<form id = 'payment-form'>" +
        "<div class='row'>" +
        "<div class='col-12 col-lg-6 offset-lg-3'>" +
        "<label>Name on Card *</label>" +
        "<input class='form-control' name='cardname' placeholder='Name on Card' value='My Name' required>" +
        "</div>" +
        "<div class='col-12 col-lg-6 offset-lg-3'>" +
        "<label>Card Number*</label>" +
        "<input class='form-control' name='cardnum' placeholder='Card Number' value='4242424242424242' required>" +
        "</div>" +
        "<div class='col-lg-2 offset-lg-3 col-sm-12'>" +
        "<label>Month*</label>" +
        "<select class='form-control' name='exp_month' placeholder='MM' required>" +
        "<option value = '01'>01-January</option><option value = '02'>02-February</option>" +
        "<option value = '03'>03-March</option><option value = '04'>04-April</option>" +
        "<option value = '05'>05-May</option><option value = '06'>06-June</option>" +
        "<option value = '07'>07-July</option><option value = '08'>08-August</option>" +
        "<option value = '09'>09-September</option><option value = '10'>10-October</option>" +
        "<option value = '11'>11-November</option><option value = '12'>12-December</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-2 col-sm-12'>" +
        "<label>Year*</label>" +
        "<input class='form-control' name='exp_year' placeholder='YYYY' value='2024' required>" +
        "</div>" +
        "<div class='col-lg-2 col-sm-12'>" +
        "<label>Security Code*</label>" +
        "<input class='form-control' name='cvc' placeholder='***' required value='123'>" +
        "</div>" +
        "</div>" +
        "</form>";


    return {
        showOffer: showOffer,
    };
})(jQuery);


/*
from granitesme cart.js:


    var subscribe = function(id) {
        $.ajax({
            type: 'POST',
            url: '/cart/subscribe',
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "package_id": id,
            },
            cache: false,
        })
        .done(show_cart)
        .fail(function(message) {
            common.ajax_fail(message);
        });
    };

    var show_cart = function() {
        options = [];
        $('#genericModal').modal(options);
        $('#genericModal #modal-close').on('click', function() {
            $('#genericModal').modal('hide');
            $('#genericModal').modal('dispose');
        });

        $.ajax({
            type: 'get',
            url: '/cart',
            cache: false,
            dataType: 'html',
        })
        .done(function(html) {
            $('.modal-body').html(html);
            $('.modal-title').html(cart_header);
            $('.modal-footer').html(cart_footer);

            $('#btn-checkout').off('click').on('click', checkout);
        })
        .fail(function(message) {
            common.ajax_fail(message);
        });
    };

    var checkout = function() {
        $.ajax({
            type: 'get',
            url: '/cart/checkout',
            cache: false,
        })
        .done(function(html) {
            $('.modal-body').html(html);
            $('.modal-title').html(register_header);
            $('.modal-footer').html(register_footer);
            $('#btn-register').off('click').on('click', register);
        })
        .fail(function(message) {
            common.ajax_fail(message);
        });
    };

    var register = function() {
        var data = $('#register-form').serializeArray(); // convert form to array
        data.push({
            name: "_token",
            value: $("meta[name='csrf-token']").attr("content")
        });

        $.ajax({
            url: "/cart/register",
            cache: false,
            data: data,
            method: 'POST',
            dataType: 'html',
        })
        .done(function(html) {
            $('.modal-body').html(html);
            $('.modal-title').html(payment_header);
            $('.modal-footer').html(payment_footer);
            $('#btn-payment').off('click').on('click', payment);
        })
        .fail(function(message) {
            common.ajax_fail(message);
        });
    };

    var payment = function() {
        var data = $('#payment-form').serializeArray(); // convert form to array
        data.push({
            name: "_token",
            value: $("meta[name='csrf-token']").attr("content")
        });

        $.ajax({
            url: "/cart/payment",
            cache: false,
            data: data,
            method: 'POST',
            dataType: 'html',
        })
        .done(function(html) {
            $('.modal-body').html(html);
            $('.modal-title').html(complete_header);
            $('.modal-footer').html(complete_footer);
            $('#btn-complete').off('click').on('click', function() {
                document.location = '/login';
            });
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });
    };

    var cart_header = "<span style='font-weight: 700; color: gray'>"+
    "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#002244'>1: Subscription</span>&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;2: Register&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;3: Payment&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;4: Complete&nbsp;&nbsp;&nbsp;&nbsp;</span>" ;

    var cart_footer = "<div class='container'><div class='row'><div class='offset-lg-10 col-lg-2'>" +
    "<button id='btn-checkout' type='button' class='btn btn-primary w-100'>Lets Get Started!</button>" +
    "</div></div></div>";

    var register_header = "<span style='font-weight: 700; color: gray'>"+
    "&nbsp;&nbsp;&nbsp;&nbsp;1: Subscription&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: #002244'>2: Register</span>&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;3: Payment&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;4: Complete&nbsp;&nbsp;&nbsp;&nbsp;</span>";

    var register_footer = "<div class='container'><div class='row'><div class='offset-lg-10 col-lg-2'>" +
    "<button id='btn-register' type='button' class='btn btn-primary w-100'>Sign Me Up!</button>" +
    "</div></div></div>";

    var payment_header = "<span style='font-weight: 700; color: gray'>"+
    "&nbsp;&nbsp;&nbsp;&nbsp;1: Subscription&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;2: Register&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: #002244'>3: Payment</span>&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;4: Complete&nbsp;&nbsp;&nbsp;&nbsp;</span>";

    var payment_footer = "<div class='container'><div class='row'><div class='offset-lg-10 col-lg-2'>" +
    "<button id='btn-payment' type='button' class='btn btn-primary w-100'>Take My Money!</button>" +
    "</div></div></div>";

    var complete_header = "<span style='font-weight: 700; color: gray'>"+
    "&nbsp;&nbsp;&nbsp;&nbsp;1: Subscription&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;2: Register&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;3: Payment&nbsp;&nbsp;&nbsp;&nbsp;|" +
    "&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: #002244'>4: Complete</span>&nbsp;&nbsp;&nbsp;&nbsp;</span>";

    var complete_footer = "<div class='container'><div class='row'><div class='offset-lg-10 col-lg-2'>" +
    "<button id='btn-complete' type='button' class='btn btn-primary w-100'>Go To Login!!</button>" +
    "</div></div></div>";

*/

/*


*/


/*
<p>Success!!</p>
*/
