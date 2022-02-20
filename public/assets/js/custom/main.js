// $(document).ready(function() {
let folder = 'hr-payroll';
(function($) {
    'use strict';

    $('[required]').focus(function (){
        $('[required]').on('keyup',function (){
            if ($(this).val().length === 0 )
            {
                $(this).css('border', '1px solid red')
            }
            else {
                $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
            }
            return true
        })
        if ($(this).val().length === 0 )
        {
            $(this).css('border', '1px solid red')
        }
        else {
            $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
        }
        return true

    });
    $('[required]').blur(function (){

        if ($(this).val().length === 0 )
        {
            $(this).css('border', '1px solid red')
        }
        else {
            $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
        }
        return true
    });
    // $('[required]').onkeyup(function (){
    //
    //     if ($(this).val().length === 0 )
    //     {
    //         $(this).css('border', '1px solid red')
    //     }
    //     else {
    //         $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
    //     }
    //     return true
    // });

    // For small pagination group
    $('.position .pagination').addClass('pagination-sm')

    $('.edit-check input[type="checkbox"]').change(function (){
        let id = $(this).attr('name')
        if ($(this).is(':checked'))
        {
            if (id === 'bonus')
            {
                $('#b_no').attr('required','required')
                $('#b_no').removeAttr('disabled')
                $('#b_amount').attr('required','required')
                $('#b_amount').removeAttr('disabled')
                $('#b_no_RO').html('Required')
                $('#b_amount_RO').html('Required')
                $('#b_no_RO').addClass('text-success')
                $('#b_amount_RO').addClass('text-success')
                $('#b_no_RO').removeClass('text-primary')
                $('#b_amount_RO').removeClass('text-primary')
            }
            else {
                $('#'+id).attr('required','required')
                $('#'+id).removeAttr('disabled')
                $('#'+id+'_RO').html('Required')
                $('#'+id+'_RO').addClass('text-success')
                $('#'+id+'_RO').removeClass('text-primary')
            }
        }
        else {
            if (id === 'bonus')
            {
                $('#b_no').removeAttr('required','required')
                $('#b_no').attr('disabled','disabled')
                $('#b_amount').removeAttr('required','required')
                $('#b_amount').attr('disabled','disabled')
                $('#b_no_RO').html('Optional')
                $('#b_amount_RO').html('Optional')
                $('#b_no_RO').addClass('text-primary')
                $('#b_amount_RO').addClass('text-primary')
                $('#b_no_RO').removeClass('text-success')
                $('#b_amount_RO').removeClass('text-success')
            }
            else {
                $('#'+id).removeAttr('required')
                $('#'+id).attr('disabled','disabled')
                $('#'+id+'_RO').html('Optional')
                $('#'+id+'_RO').addClass('text-primary')
                $('#'+id+'_RO').removeClass('text-success')
            }

        }
    })
    $('#npass').keyup(function (){
        let v1 = $(this).val()
        let v2 = $('#cpass').val()
        if (v1 === v2)
        {
            $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#cpass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#message').html('Both password match')
            $('#message').addClass("text-success")
            $('#message').removeClass("text-danger")
        }
        else {
            $(this).css('border', '1px solid red')
            $('#cpass').css('border', '1px solid red')
            $('#message').html("Both password doesn't match")
            $('#message').addClass("text-danger")
            $('#message').removeClass("text-success")
        }
    })
    $('#cpass').keyup(function (){
        let v1 = $(this).val()
        let v2 = $('#npass').val()
        if (v1 === v2)
        {
            $(this).css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#cpass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#message').html('Both password match')
            $('#message').addClass("text-success")
            $('#message').removeClass("text-danger")
        }
        else {
            $(this).css('border', '1px solid red')
            $('#cpass').css('border', '1px solid red')
            $('#message').html("Both password doesn't match")
            $('#message').addClass("text-danger")
            $('#message').removeClass("text-success")
        }
    })
    // $('#loader').bind('ajaxStart', function(){
    //     $(this).show();
    // }).bind('ajaxStop', function(){
    //     $(this).hide();
    // });
})(jQuery);

function emptyField(e)
{
    let unfilled = $('[required]').filter(function() {
        return $(this).val().length === 0
    });
    if ($('#Phone').val().length != 0)
    {
        if ($('#PhoneCode').val().length === 0)
        {
            $('#PhoneCode').css('border', '1px solid red')
        }
    }
    if (unfilled.length > 0) {
        // still unfilled inputs
        unfilled.css('border', '1px solid red')
    }
}
function previewFile(input){
    let id = $(input).attr('preview')
    let file = $(input).get(0).files[0];
    if(file.size > (1024*1000) && id === 'profile-preview')
    {
        alert('Profile image can not accept more then 1Mb')
        $(input).css('border', '1px solid red')
        return false
    }
    else if(file.size > (1536*1000) && id === 'cover-preview')
    {
        alert('Cover image can not accept more then 1.5Mb')
        $(input).css('border', '1px solid red')
        return false
    }
    else {
        $(input).css('border', '1px solid rgba(71, 164, 71, 0.5)')
    }
    if(file){
        let reader = new FileReader();
        reader.onload = function(){
            $("#"+id).attr("src", reader.result);
        }

        reader.readAsDataURL(file);
    }
}


// For Department filter
function filterDep(e)
{
    let value = $(e).val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/department-filter",
        type:"POST",
        data:{"v":value},
        success:function (data)
        {
            $('#dep-table').html(data)
        }
    })

}
// For Department search
function searchDep(e)
{
    let value = $(e).val();
    if (value.length <= 0)
    {
        location.reload();
    }
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/department-search",
        type:"POST",
        data:{"v":value},
        success:function (data)
        {
            $('#dep-table').html(data)
        }
    })
}
// For department code check
function checkCode(e)
{
    let value = $(e).val();
    if (value.length === 3)
    {
        let url = window.location.origin
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/department-code-check",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                if (data)
                {
                    alert('This Code are already use')
                    $(e).css('border', '1px solid red')
                }
                else {
                    $(e).css('border', '1px solid rgba(71, 164, 71, 0.5)')
                }
            }
        })
    }
    else {
        $(e).css('border', '1px solid red')
    }
}

// For Position Search
function searchPosition(event)
{
    let value = $(event).val();
    if (value.length <= 0)
    {
        location.reload();
    }
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/employee/position-search",
        type:"POST",
        data:{"v":value},
        success:function (data)
        {
            // console.log(data)
            $('#position-table').html(data)
        }
    })
}

// For grade search check
function searchGrade(e)
{
    let value = $(e).val();
    if (value.length <= 0)
    {
        location.reload();
    }
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/grade/salary/grade-search",
        type:"POST",
        data:{"v":value},
        success:function (data)
        {
            $('#grade-table').html(data)
        }
    })
}
//Auto generate Password
function generatePassword()
{
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/employee/auto-password",
        type:"POST",
        success:function (data)
        {
            $('#npass').attr('type','text')
            $('#cpass').attr('type','text')
            $('#toggol').html('Hide')
            $('#npass').val(data)
            $('#cpass').val(data)
            $('#npass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#cpass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#npass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#cpass').css('border', '1px solid rgba(71, 164, 71, 0.5)')
            $('#message').html('Both password match')
            $('#message').addClass("text-success")
            $('#message').removeClass("text-danger")
        }
    })
}
//Show password
function showPassword(e)
{
    if ($('#npass').attr('type') === 'password' || $('#cpass').attr('type') === 'password')
    {
        $(e).html('Hide')
        $('#npass').attr('type','text')
        $('#cpass').attr('type','text')
    }
    else {
        $(e).html('Show')
        $('#npass').attr('type','password')
        $('#cpass').attr('type','password')
    }
}
//Employee email duplicate check
function checkEmpEmail(e)
{

    let value = $(e).val();
    let url = window.location.origin
    let pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i
    if (value.length > 0 && pattern.test(value))
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/email-check",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                if (data == 1)
                {
                    alert(value+" already use")
                }
            }
        })
    }
}
// Employee Search on set grade page
function searchEmp(e)
{
    let value = $(e).val();
    let url = window.location.origin
    if (value.length > 0 )
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/search-employee",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                $('#epm-info').html(data)
            }
        })
    }
    else {
        $('#epm-info').html('<tr>\n' +
            '    <td colspan="4" class="text-center">Not Found!</td>\n' +
            '</tr>')
    }
}
function searchEmpByFind(e)
{
    let value = $(e).val();
    let url = window.location.origin
    if (value.length > 0 )
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/search-employee",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                $('#epm-info').html(data)
            }
        })
    }
    else {
        $('#epm-info').html('<tr>\n' +
            '    <td colspan="4" class="text-center">Not Found!</td>\n' +
            '</tr>')
    }
}
//Change Employee Status
function changeEmpStatue(e)
{
    if(!confirm('Are You Sure Change the status?'))
    {
        return false
    }
    let value = $(e).val();
    let status = $(e).attr('status');
    let url = window.location.origin
    if (status === '0' || status === '1')
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/change-employee-status",
            type:"POST",
            data:{"v":value,"status":status},
            success:function (data)
            {
                if (data === '0')
                {
                    alert('Status Update Not Possible')
                }
                else if(status === '0' && data === '1')
                {
                    //Data is Inactive
                    $('#status').html('Inactive')
                    $('#status').removeClass('text-success')
                    $('#status').addClass('text-danger')
                    $(e).html('Make Active')
                    $(e).attr('status','1')
                    $(e).removeClass('btn-outline-danger')
                    $(e).addClass('btn-outline-success')
                }
                else if(status === '1' && data === '1')
                {
                    //Data is active
                    $('#status').html('Active')
                    $('#status').removeClass('text-danger')
                    $('#status').addClass('text-success')
                    $(e).html('Make Inactive')
                    $(e).attr('status','0')
                    $(e).removeClass('btn-outline-success')
                    $(e).addClass('btn-outline-danger')
                }
                else {
                    location.reload();
                }
            }
        })
    }
    return false
}
// search employee on employee list
function searchEmpList(e)
{
    let value = $(e).val();
    let url = window.location.origin
    if (value.length > 0 )
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/search-employee-list",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                $('#emp-table').html(data)
            }
        })
    }
    else {
        location.reload();
    }
}
// Filter by role on employee list page
function filterEmp(e)
{
    let value = $(e).val();
    let url = window.location.origin
    if (value > 0 )
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/filter-employee-list",
            type:"POST",
            data:{"v":value},
            success:function (data)
            {
                $('#emp-table').html(data)
            }
        })
    }
    else {
        location.reload();
    }
}
//ID generator Via department change
function idGeneratorByDep(e)
{
    let value = $(e).val();
    if (value === '0')
    {
        return false
    }
    if(!confirm('Are you sure change this Department? If you change department then employee ID will be change automatic'))
    {
        return false
    }

    let id = $(e).attr('data')
    let url = window.location.origin
    if (value > 0 && id)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url+"/"+folder+"/public/admin/employee/set-id",
            type:"POST",
            data:{"v":value,"id":id},
            success:function (data)
            {
                if (data) location.reload()
                else alert("Change not Possible!")
            }
        })
    }
    else {
        return false
    }
}
//leave time calculate
function leaveTime(e)
{
    let entry = parseInt($('#entry_time').val());
    let w_hour = parseInt($('#w-hour').val());
    let leave = (entry + w_hour)
    let h24 = moment.utc(entry,'HH:mm:ss').add(w_hour,'hour').format('HH:mm:ss')
    // alert(leave)
    // return false
    // let h24 = leave+':00:00';
    let ampm = leave >= 12 ? 'pm' : 'am'
    leave = ((entry+w_hour) % 12)
    // (leave === 0)?leave =12:leave
    leave = leave ? leave : 12
    leave = leave < 10 ? '0'+leave:leave
    leave = leave+':00 '+ampm
    $('#leave_time').html('<option value="'+h24+'">'+leave+'</option>')

}
//Search Employee for attendance page
function searchEmpForAttendance(e)
{
    let value = $(e).val();
    let url = window.location.origin
    if (value.length<=0)
    {
        $('#epm-info').html('')
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/attendance/search-employee",
        type:"POST",
        data:{"v":value},
        success:function (data)
        {
            $('#epm-info').html(data)
        }
    })
}
//attendance Entry
function searchAttendance(e) {
    let emp = $('#emp').val()
    let year = $('#year').val()
    let month = $('#month').val()
    let date = $('#date').val()
    let dep = $('#dep').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/attendance/filter-attendance",
        type:"POST",
        data:{"emp":emp,'year':year,'month':month,'date':date,'dep':dep},
        success:function (data)
        {
            $('#att-data').html(data)
            // console.log(data)
        }
    })
}
//attendance Entry
function searchAttendanceEmp(e) {
    let year = $('#year').val()
    let month = $('#month').val()
    let date = $('#date').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/employee/attendance/filter-attendance",
        type:"POST",
        data:{'year':year,'month':month,'date':date},
        success:function (data)
        {
            $('#att-data').html(data)
            // console.log(data)
        }
    })
}
//attendance Entry
function searchAttendanceProjectManager(e) {
    let year = $('#year').val()
    let month = $('#month').val()
    let date = $('#date').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/project-manager/attendance/filter-attendance",
        type:"POST",
        data:{'year':year,'month':month,'date':date},
        success:function (data)
        {
            $('#att-data').html(data)
            // console.log(data)
        }
    })
}
//Search salary data in list month
function fiendSalaryData(e)
{
    let dep = $('#dep_id').val()
    let emp = $('#emp').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/payroll/search-salary-list",
        type:"POST",
        data:{"emp":emp,"dep":dep},
        success:function (data)
        {
            $('#salary-data').html(data)
        }
    })
}
//Search salary data in list month
function fiendAllSalaryData(e)
{
    let year = $('#year').val()
    let month = $('#month').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/payroll/search-all-salary-list",
        type:"POST",
        data:{"emp":emp,"year":year,"month":month},
        success:function (data)
        {
            $('#salary-data').html(data)
        }
    })
}
//Search project manager salary data in list month
function fiendProjectManagerSalaryData(e)
{
    let year = $('#year').val()
    let month = $('#month').val()
    let dep = $('#dep').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/project-manager/payroll/search-all-salary-list",
        type:"POST",
        data:{"dep":dep,"year":year,"month":month},
        success:function (data)
        {
            $('#salary-data').html(data)
        }
    })
}
//delete all data list month of salary list
function deleteListMonthSalary()
{
    if(confirm('Are you sure delete this month salary list'))
    {
        let url = window.location.origin
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + "/" + folder + "/public/admin/payroll/delete-salary-list",
            type: "POST",
            success: function (data) {
                if (data)
                {
                    $('#salary-data').html('<tr><td colspan="10" class="text-danger text-center"></td></tr>')
                }
            }
        })
    }
    else {
        return false
    }
}
function recruitmentSearch(e)
{
    let dep = $('#dep').val()
    let title = $('#title').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/recruitment/search-recruitment-list",
        type:"POST",
        data:{"title":title,"dep":dep},
        success:function (data)
        {
            $('#recr-data').html(data)
        }
    })
}
function searchCV(e)
{
    let dep = $('#dep').val()
    let title = $('#title').val()
    let input = $('#name').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/recruitment/search-cv",
        type:"POST",
        data:{"title":title,"dep":dep,'input':input},
        success:function (data)
        {
            $('#cv-data').html(data)
        }
    })
}
function searchSmProject(e)
{
    let project = $(e).val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/project/project-sm-search",
        type:"POST",
        data:{"project":project},
        success:function (data)
        {
            $('#project-sm-list').html(data)
        }
    })
}
function searchSmTeam(e)
{
    let project = $(e).val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/project/team-sm-search",
        type:"POST",
        data:{"team":project},
        success:function (data)
        {
            $('#project-sm-list').html(data)
        }
    })
}
//search proposed loan
function searchProposedLoan(e)
{
    let value = $(e).val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/loan/proposed-loan-search",
        type:"POST",
        data:{"data":value},
        success:function (data)
        {
            $('#proposed-loan-list').html(data)
        }
    })
}
//calculate End date
function calculateEndDate(e)
{
    let start = $('#start').val()
    let duration = $('#duration').val()
    let monthYear = $('#monthYear').val()
    let end = null
    if (start.length != 0 && duration.length != 0 && monthYear.length != 0)
    {
        if (monthYear === 'years')
        {
            end = moment.utc(start, "YYYY-MM-DD").add(duration,'years').format('MM/DD/YYYY');
        }
        else {
            end = moment.utc(start, "YYYY-MM-DD").add(duration, 'months').format('MM/DD/YYYY');
        }
        $('#end').html("<option value='"+ end +"'>"+ end +"</option>")
    }
    else {
        return false
    }
}

function searchTaskForProjectManager(e)
{
    let task = $(e).val()
    let abc = $(e).attr('abc')
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/project-manager/project/task-sm-search",
        type:"POST",
        data:{"team":task,"abc":abc},
        success:function (data)
        {
            $('#task-sm-list').html(data)
        }
    })
}
//search loan application list for administration
function searchLoanApplication(e)
{
    let user = $('#user').val()
    let status = $('#status').val()
    let title = $('#title').val()
    let order = $('#order').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/loan/loan-application-search",
        type:"POST",
        data:{"user":user,"status":status,"title":title,"order":order},
        success:function (data)
        {
            $('#application-loan-list').html(data)
        }
    })
}
//search loan Running list for administration
function searchLoanRunning(e)
{
    let user = $('#user').val()
    let status = $('#status').val()
    let title = $('#title').val()
    let order = $('#order').val()
    let url = window.location.origin
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url+"/"+folder+"/public/admin/loan/loan-running-search",
        type:"POST",
        data:{"user":user,"status":status,"title":title,"order":order},
        success:function (data)
        {
            $('#application-loan-list').html(data)
        }
    })
}
function HTMLtoPDF(paravalue){
    var backup = document.body.innerHTML;
    var singlediv = document.getElementById(paravalue).innerHTML;
    document.body.innerHTML = singlediv;
    window.print();
    document.body.innerHTML = backup;
}
