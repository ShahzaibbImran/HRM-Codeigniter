
/* 
 * Tooltips icon
 */
$(document).ready(function(){
	$('body').prepend('<div id="cover"></div>');
}); 

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
/* 
 * Time and Date Pickers
 */
$(function () {
    $('.timepicker').timepicker();
    $('.slider').slider({
        formatter: function (value) {
            return 'Current value: ' + value;
        }
    });
});

$(function () {
    $('.timepicker2').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });
});

$(function () {
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
    });
});
$(function () {
    $('.monthyear').datepicker({
        autoclose: true,
        startView: 1,
        format: 'yyyy-mm',
        minViewMode: 1,
    });
});

$(function () {
    $('.years').datepicker({
        startView: 2,
        format: 'yyyy',
        minViewMode: 2,
        autoclose: true,
    });
});
$(function () {
    $('.weeks').datepicker({
        autoclose: true,
        calendarWeeks: true,
    }).on('show', function (e) {

        var tr = $('body').find('.datepicker-days table tbody tr');

        tr.mouseover(function () {
            $(this).addClass('week');
        });

        tr.mouseout(function () {
            $(this).removeClass('week');
        });

        calculate_week_range(e);

    }).on('hide', function (e) {
        console.log('date changed');
        calculate_week_range(e);
    });

    var calculate_week_range = function (e) {

        var input = e.currentTarget;

        // remove all active class
        $('body').find('.datepicker-days table tbody tr').removeClass('week-active');

        // add active class
        var tr = $('body').find('.datepicker-days table tbody tr td.active.day').parent();
        tr.addClass('week-active');

        // find start and end date of the week

        var date = e.date;
        var start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
        var end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);

        // make a friendly string

        var friendly_string = start_date.getFullYear() + '-' + (start_date.getMonth() + 1) + '-' + start_date.getDate() + ' to '
                + end_date.getFullYear() + '-' + (end_date.getMonth() + 1) + '-' + end_date.getDate();

        console.log(friendly_string);

        $(input).val(friendly_string);

    }
});
$(function () {
    $('button[id="checkit"]').click(function () {
        $('#month').css("display", "block").css("margin-top", "20" + "px");
    });
});
/* 
 * Session Academic Calender 
 */
$(function () {
    $('div.other').show();
    $('input[id="checkit"]').click(function () {
        $('#show').css("display", "").css("margin-top", "20" + "px");
        if (this.checked) {
            $('div.other').hide();
        } else {
            $('div.other').show();
        }
    });
});
$(document).ready(function () {
    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});

/* 
 * Session Create Class Select One class One Shift And save Data
 */

$(document).ready(function () {
    $('input.select_class').on('change', function () {
        $('input.select_class').not(this).prop('checked', false);
    });
});


$(document).ready(function () {
    $('input.select_shift').on('change', function () {
        $('input.select_shift').not(this).prop('checked', false);
    });
});
/* 
 * Show all alert
 */
$(document).ready(function () {
    setTimeout(function () {
        $(".alert").fadeOut("slow", function () {
            $(".alert").remove();
        });

    }, 3000);
});

/* 
 * Teacher Management Add Marks check and show input
 */
$(function () {
    $('div.term').hide();
    $('input[id="checkit"]').click(function () {
        if (this.checked) {
            $('div.term').hide();
        } else {
            $('div.term').show();
        }
    });
});
$(function () {
    $('div.assessment').hide();
    $('input[id="checked"]').click(function () {
        if (this.checked) {
            $('div.assessment').show();
        } else {
            $('div.assessment').hide();
        }
    });
    /*
     * Multiple drop down select
     */

    $(document).ready(function () {
        $(".select_box").select2({});
        $(".select_2_to").select2({
            placeholder: "To:",
            tags: true,
            allowClear: true,
            tokenSeparators: [',', ' ']
        });
    });
});

/*
 * Select All select
 */
$(function () {
    $('#parent_present').on('change', function () {
        $('.child_present').prop('checked', $(this).prop('checked'));
    });
    $('.child_present').on('change', function () {
        $('.child_present').prop($('.child_present:checked').length ? true : false);
    });
    $('#parent_absent').on('change', function () {
        $('.child_absent').prop('checked', $(this).prop('checked'));
    });
    $('.child_absent').on('change', function () {
        $('.child_absent').prop($('.child_absent:checked').length ? true : false);
    });
});
/*
 * Click to show 
 */

$(function () {
    $('div.a_category').hide();
    $('input[id="parent_absent"]').click(function () {
        if (this.checked) {
            $('div.a_category').show();
        } else {
            $('div.a_category').hide();
        }
    });
});

$(document).ready(function () {
    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});
$(document).ready(function () {
    $('#leave_category').on('change', function () {
        $('#start_date').val('');
        $('#end_date').val('');
    });
});
$(function () {
    $('#parent').on('change', function () {
        $('.child').prop('checked', $(this).prop('checked'));
    });
    $('.child').on('change', function () {
        $('#parent').prop($('.child:checked').length ? true : false);
    });
});

// Attendance With Leave Category Select One 

$(document).ready(function () {
    //var id = $('input[class^="child_present"]').length;

//    var i;
//    for (i = 1; i <= id; i++)
////    {
////        alert(i);
////        $('input.child_present_'+i).on('change', function() {
////            $('input.child_present_'+i).not(this).prop('checked', false);
////        });
////    }
    var parent_absent = $('input[id="parent_absent"]');
    var parent_present = $('input[id="parent_present"]');
    var child_present = $('input[class="child_present"]');

    var child_absent = $('input[class="child_absent"]');

    $('select[id="disable"]').prop('disabled', true);
    child_absent.click(function () {
        if (this.checked) {
            $('select[id="disable"]').prop('disabled', false);
        }
    });
    parent_absent.change(function () {
        if (this.checked) {
            child_present.prop('checked', false);
        }
    });
    parent_present.change(function () {
        if (this.checked) {
            child_absent.prop('checked', false);
        }
    });
    child_present.change(function () {
        parent_absent.prop($('input[class="child_present"]').length === 0);
    }).change();
    child_absent.change(function () {
        parent_present.prop($('input[class="child_absent"]').length === 0);
    }).change();
});




// fees management fees collecion make payment start
function changeval2() {
    $total = parseFloat($("#fees_amount").val()) + parseFloat($("#fine").val()) - parseFloat($("#discount").val());
    $("#total_amount").val($total);
    $("#total_amount1").val($total);
}
// fees management fees collecion make payment end

function global_message(message){
	var div = $('.global_message')
	setTimeout(function(){
			div.html(message);
			div.slideDown(function(){
				setTimeout(function(){
					div.slideUp();
				},4000)
			});
				
		})
}

