var library = (function ($, undefined) {

    var drawEntry = function(el) {
        html = "<div class='bg-primary border border-primary rounded-2' role='button' onclick=\"dashboard.show('entry', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-1' style='text-align:center'>";
        html += "<i class='fa-regular fa-el.icon'></i>";
        html += "</div>";
        html += "<div class='col-md-3' style='text-align:right'>";
        html += dateFormat(el.next_due_date);
        html += "</div>";

        html += "<div class='col-md-2' style='text-align:right'>";
        html += el.amount;
        html += "</div>";

        html += "<div class='col-md-6' style='text-align:left'>";
        html += el.name;
        html += "</div>";

        html += '</div>';
        html += '</div>';
        return html;
    };

    var drawAccount = function(el) {
        html = "<div class='bg-primary border border-primary rounded-2' role='button' onclick=\"dashboard.show('account', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12'>";
        html += el.name;
        html += "</div>";
        html += '</div>';
        html += '</div>';
        return html;
    };

    var drawParty = function(el) {
        html = "<div class='bg-primary border border-primary rounded-2' role='button' onclick=\"dashboard.show('party', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12'>";
        html += el.name;
        html += "</div>";
        html += '</div>';
        html += '</div>';
        return html;
    };

    var drawCategory = function(el) {
        html = "<div class='bg-primary border border-primary rounded-2' role='button' onclick=\"dashboard.show('category', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12'>";
        html += el.label;
        html += "</div>";
        html += '</div>';
        html += '</div>';
        return html;
    };

    var dateFormat = function(value) {
        var dateval = new Date(value);
        return dateval.toDateString();
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
