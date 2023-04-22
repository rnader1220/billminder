var library = (function ($, undefined) {

    var drawEntry = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row entry-"+ el.status+"' onclick=\"dashboard.show('entry', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-xs-2 col-md-1 centered'>";
        html += ""+entryIcon(el.status);
        html += "</div>";
        html += "<div class='col-xs-4 col-md-2' style='text-align:right'>";
        html += dateFormat(el.next_due_date);
        html += "</div>";

        html += "<div class='col-xs-4 col-md-2' style='text-align:right'>";
        html += el.amount;
        html += "</div>";

        html += "<div class='col-xs-6 col-md-4' style='text-align:left'>";
        html += el.name;
        html += "</div>";
        html += "<div class='col-xs-6 col-md-3' style='text-align:left'>";
        html += el.category;
        html += "</div>";

        html += '</div></div></div>';
        return html;
    };

    var entryIcon = function(status) {
        switch (status) {
            case 'income': return '<i class="fa-solid fa-money-bill-wave"></i>';
            case 'late': return '<i class="fa-solid fa-triangle-exclamation"></i>';
            case 'due': return '<i class="fa-solid fa-alarm-clock"></i>';
            case 'expense': return '<i class="fa-solid fa-file-invoice-dollar"></i>';
        }
    };

    var drawAccount = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row account' onclick=\"dashboard.show('account', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12 centered'>";
        html += el.name;
        html += "</div>";
        html += '</div>';
        html += '</div></div></div>';
        return html;
    };

    var drawCategory = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row category' onclick=\"dashboard.show('category', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12 centered'>";
        html += el.label;
        html += "</div>";
        html += '</div>';
        html += '</div></div></div>';
        return html;
    };

    var dateFormat = function(value) {
        var dateval = new Date(value);
        return dateval.toDateString().substring(4,10);
    };

    var drawButton = function(attr) {
        htmlString = "<button title='" + attr.title + "' type='button' ";
        htmlString += "class='btn btn-primary btn-utility' id='" + attr.btn_id + "'>";
        if (attr.hasOwnProperty('icon')) {
            htmlString += "<span class='" + attr.icon + "'></span>";
        }
        if (attr.hasOwnProperty('label')) {
            htmlString += "<span>&nbsp;" + attr.label + "</span>";
        }
        htmlString += '</button>';
    };

    var drawElement = function(type, el) {
        switch(type) {
            case('entry'):
                return drawEntry(el);
            case('account'):
                return drawAccount(el);
            case('party'):
                return drawParty(el);
            case('category'):
                return drawCategory(el);
        }
        return '';
    };


    return {
        drawElement: drawElement,
        drawButton: drawButton,
    };
})(jQuery);
