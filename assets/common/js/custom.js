$(document).on('change', 'select', function (e) {
    $(this).next("p.error").remove();
});
$(document).on('focus', 'input', function (e) {
    $(this).next("p.error").remove();
});
$(document).on('change', 'input', function (e) {
    $(this).next("p.error").remove();
});

var $table = $("#table");

function detailFormatter(index, row) {
    var html = [];
    $.each(row, function (key, value) {
        html.push("<p><b>" + key + ":</b> " + value + "</p>");
    });
    return html.join("");
}

function initTable() {
    /* $table.bootstrapTable("destroy").bootstrapTable({
        stickyHeader: true,
        stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
        stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
        theadClasses: 'undefined'
    }); */

    var height = $(window).height();
    var top_section_height = $('.top-form-section').height();
    height = height-(top_section_height+parseInt(60)+parseInt(38)+parseInt(20)+parseInt(53));
    console.log(height);
    $table.bootstrapTable("destroy").bootstrapTable({
        height: height,
        locale: "en-US",
    });

    $(document).find('th.hidden').each(function () {
        var field = $(this).attr('data-field');

        $table.bootstrapTable('hideColumn', field)
    })

    $table.on("all.bs.table", function (e, name, args) {
        //console.log(name, args);
    });

    $table.on('post-header.bs.table', function () {
        $('.select2').select2();
        
    });
}

function save_dynamic_view() {
    let all_fields = $table.bootstrapTable('getVisibleColumns').map(function (it) {
        return it.field
    })
    let data_url = $(document).find('.save_dynamic_view').data('url');
    let arr_data = {};
    $.each(all_fields, function (key, value) {
        arr_data[key] = value;
    });

    $.ajax({
        url: data_url,
        type: "POST",
        data: arr_data,
        dataType: "json",
    }).done(function (resp) {
        if (resp.status == "success") {

            swal("Success", 'View is saved successfully.', "success");
        } else {
            swal("Error", "Something is went wrong please try again.", "error");
        }
    });

    console.log(all_fields);
}

$(document).on('click', '.save_dynamic_view', function () {
    save_dynamic_view();
})

$(function () {
    initTable();
});


function BtnLoading(elem, text = 'Processing...') {
    $(elem).attr("data-original-text", $(elem).html());
    $(elem).prop("disabled", true);
    $(elem).html('<i class="spinner-border spinner-border-sm"></i> ' + text);
}

function BtnReset(elem) {
    $(elem).prop("disabled", false);
    $(elem).html($(elem).attr("data-original-text"));
}

$(document).ready(function () {
    const elements = $(document).find('input');
    $(elements).attr("data-lpignore", "true");
    $(elements).attr("autocomplete", "off");
});

function ShowBodyLoader() {
    $(document).find('.full-body-loader').removeClass('d-none');
}

function HideBodyLoader() {
    $(document).find('.full-body-loader').addClass('d-none');
}
