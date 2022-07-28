
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

/////////////////////////////////////////////////////


var active;

$(document).ready(function () {

    const todayDate = new Date();
    $( ".dateFilter" ).datepicker({
        dateFormat: 'yy-mm-dd',//check change
        changeMonth: true,
        changeYear: true
    });
    // var todayM = todayDate.getMonth();
    // var todayD = todayDate.getDate();
    // var pastD = todayD - 3;
    // var todayY = todayDate.getFullYear();


    // $(".dateFilter").datepicker();

    $("#category").keyup(function (e) {

        var code = e.which;

        if (code == 40) { //key down                     
            active++;

            if (active >= $('#category_list ul li').length)
                active = 0;//$('#drList ul li').length;

            switchActiveElement();
            console.log(active);
        } else if (code == 38) { //key up
            active--;
            if (active < 0)
                active = $('#category_list ul li').length - 1;

            switchActiveElement();
            console.log(active);
        } else if (code == 13) { //enter key
            selectOption($('.active'));


        } else {
            var query = $("#category").val();
            // print(query);

            if (query.length > 0) {
                $.ajax(
                    {
                        url: 'ajax-category-search.php',
                        method: 'POST',
                        data: {
                            // search: 1,
                            query: query
                        },
                        success: function (data) {
                            $('#category_list').fadeIn("fast");
                            $('#category_list').html(data);
                            active = -1
                            if (code = 38)
                                active = $('#category_list ul li').length;
                        },
                        dataType: 'text'
                    }
                );
            }
            else {
                $('#category_list').fadeOut();
            }
        }

    });

    $(document).on('click', '#category_list li', function () {

        $('#category').val($(this).text());
        // $('#search_dr_id').val($(this).attr('value'));
        $('#category_list').fadeOut();
    });
    $(document).on('click', function () {
        $('#category_list').fadeOut();
    });

});

function switchActiveElement() {
    $('.active').removeAttr('class');
    $('#category_list ul li:eq(' + active + ')').attr('class', 'active');
}

function selectOption(caller) {
    var country = caller.text();
    $("#category").val(country);
    $("#category_list").html("");
    $('#category_list').fadeOut();

}

/////////////////////////////////////////////////////

// function scan_master_sub(data) {

//     const ajaxreq1 = new XMLHttpRequest();
//     ajaxreq1.open('GET', 'http://localhost/hospital/admin/main/get_master_sub_scan_type.php?selectvalue=' + data, 'TRUE');

//     ajaxreq1.send();

//     ajaxreq1.onreadystatechange = function () {
//         if (ajaxreq1.readyState == 4 && ajaxreq1.status == 200) {

//             $sub_master_scan = ajaxreq1.responseText;
//             document.getElementById('sub_master_scan').innerHTML = $sub_master_scan;
//             document.getElementById('sub_master_scan').value = $sub_master_scan;

//         }
//     }
// }

// $(document).ready(function () {
//     $('[data-toggle="tooltip"]').tooltip();
// });



/////////////////////////////////////////////////////


// function scan_sub_child(data) {

//     const ajaxreq1 = new XMLHttpRequest();
//     ajaxreq1.open('GET', 'http://localhost/hospital/admin/main/get_child_scan_type.php?selectvalue=' + data, 'TRUE');

//     ajaxreq1.send();

//     ajaxreq1.onreadystatechange = function () {
//         if (ajaxreq1.readyState == 4 && ajaxreq1.status == 200) {

//             $sub_child_scan = ajaxreq1.responseText;

//             document.getElementById('sub_child_scan').innerHTML = $sub_child_scan;
//             document.getElementById('sub_child_scan').value = $sub_child_scan;
//         }
//     }
// }

// $(document).ready(function () {
//     $('[data-toggle="tooltip"]').tooltip();
// });


/////////////////////////////////////////////////////

// function original_price(data) {

//     const ajaxreq1 = new XMLHttpRequest();
//     ajaxreq1.open('GET', 'http://localhost/hospital/admin/main/get_original_price.php?selectvalue=' + data, 'TRUE');

//     ajaxreq1.send();

//     ajaxreq1.onreadystatechange = function () {
//         if (ajaxreq1.readyState == 4 && ajaxreq1.status == 200) {

//             $original_price = ajaxreq1.responseText;

//             document.getElementById('oprice').value = $original_price;

//         }
//     }
// }

// $(document).ready(function () {
//     $('[data-toggle="tooltip"]').tooltip();
// });

/////////////////////////////////////////////////////


$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

/////////////////////////////////////////////////////

$(document).ready(function(e){
    // Submit new_employee form data via Ajax
    $("#formid").on('submit', function(e){
        e.preventDefault();
        $.ajax({

            type: "POST",
            url: "insert_employee.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: new FormData(this),	

            success: function(response){ 
                $('#alerts').html(response.message);
            }
        });
    });
    
});


