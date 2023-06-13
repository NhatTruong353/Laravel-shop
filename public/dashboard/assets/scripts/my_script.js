// = = = = = = = = = = = = = = = = changeImg = = = = = = = = = = = = = = = =
function changeImg(input) {
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function (e) {
            //Thay đổi đường dẫn ảnh
            $(input).siblings('.thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

//Khi click #thumbnail thì cũng gọi sự kiện click #image
$(document).ready(function () {
    $('.thumbnail').click(function () {
        $(this).siblings('.image').click();
    });
});
$( function() {
    $( "#datepicker" ).datepicker({
        dateFormat:"yy-mm-dd"
    });
    $( "#datepicker2" ).datepicker({
        dateFormat:"yy-mm-dd"
    });
} );
$(document).ready(function (){
    chart60daysorder();
    var chart = new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'chart',
        lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766b56'],

        xkey: 'period',
        ykeys: ['order','sale','quantity'],
        behaveLikeline: true,
        labels: ['đơn hàng','doanh số($)','số lượng']
    });
    function chart60daysorder(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"admin/dashboard/day-order",
            method:"POST",
            dataType: "JSON",
            data:{_token:_token},
            success:function (data){
                chart.setData(data);
            }
        })
    }
    $('.dashboard-filter').change(function (){
        var dashboard_value = $(this).val();
        $.ajax({
            url:"admin/dashboard/dashboard-filter",
            method:"POST",
            dataType: "JSON",
            data:{dashboard_value:dashboard_value},
            success:function (data){
                chart.setData(data);
            }
        })
    })
    $('#btn-dashboard-filter').click(function (){

        var from_date = $('#datepicker').val();
        var to_date=$('#datepicker2').val();

        $.ajax({
            url:"admin/dashboard/filter-by-date",
            method:"POST",
            dataType:"JSON",
            data:{from_date:from_date,to_date:to_date},
            success:function (data)
            {
                chart.setData(data);
            }
        })
    });

})


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
