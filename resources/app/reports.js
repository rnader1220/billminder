var reports = (function ($, undefined) {

    var show = function () {
        add();
    };

    var add = function () {
        url = '/reports/create';
        $.ajax({
                url: url,
                cache: false,
                dataType: 'json'
            })
            .done(function (resp) {
                dashboard.showModalForm('reports', null, resp,
                    function () {
                        dashboard.hideModal();
                    },
                    function () {
                        store();
                    }
                );
                $('#beg_date_div').hide();
                $('#end_date_div').hide();
                $('#category_id_div').hide();
                $('#account_id_div').hide();
                $('#payee_id_div').hide();
                $('#payor_id_div').hide();
                $("input[name='type']").off().on('click', function() {set_options(this);});
            })
            .fail(function (message) {
                utility.ajax_fail(message);
            });
    };

    var set_options = function (obj) {
        $('#beg_date_div').show();
        $('#end_date_div').show();
        $('#category_id_div').show();
        switch($(obj).attr('id')) {
            case 'type-register-income':
            case 'type-entry-income':
                $('#account_id_div').show();
                $('#payor_id_div').show();
                $('#payee_id_div').hide();
                break;
            case 'type-register-expense':
            case 'type-entry-expense':
                $('#account_id_div').show();
                $('#payor_id_div').hide();
                $('#payee_id_div').show();
                break;
            default:
                $('#account_id_div').hide();
                $('#payee_id_div').hide();
                $('#payor_id_div').hide();
                break;
        }
    };


    var store = function () {
        $('.modal-body form').on('submit', function (e) {
            e.preventDefault();
            if (true) {
                var data = $(this).serializeArray();
                data.push({
                    name: "_token",
                    value: $("meta[name='csrf-token']").attr("content")
                });

                if ($(this).valid()) $.ajax({
                        type: "POST",
                        target: '#download',
                        url: '/reports/generate',
                        data: $.param(data)
                    })

                    .done(function (resp) {
                        var blob = new Blob([resp], { type: "application/octetstream" });

                        //Check the Browser type and download the File.
                        var isIE = false || !!document.documentMode;
                        if (isIE) {
                            window.navigator.msSaveBlob(blob, fileName);
                        } else {
                            var url = window.URL || window.webkitURL;
                            link = url.createObjectURL(blob);
                            var a = $("<a />");
                            a.attr("download", fileName);
                            a.attr("href", link);
                            $("body").append(a);
                            a[0].click();
                            $("body").remove(a);
                        }

                        dashboard.hideModal();

                    })
                    .fail(function (message) {
                        utility.ajax_fail(message);
                    });
            }
        }).validate(update_rules);
    };

    var update_rules = [];

    return {
        show: show,
    };
})(jQuery);
