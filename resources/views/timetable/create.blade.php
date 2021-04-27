<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css">
  #mismatch-error {
    display: none;
  }
</style>
</head>
<body>

<div class="container">
  <div id="mismatch-error" class="alert alert-danger">
    <strong>Wait!</strong> Total hrs of week does not match total hrs of subjects.

  </div>


  <h2>Time Table Create</h2>
  <hr>
  @if (Session::get('success')!="Total hours auto-genrate succesfully")

  <form class="form-horizontal" action="{{url('/time/table/save')}}" method="post">
    {{csrf_field()}}
    <div class="form-group">
      <label class="control-label col-sm-4" >No of working days:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control"  id="no_of_working_days" placeholder="Enter no of working days" name="no_of_working_days">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" >No of working hrs per day:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control" id="no_of_working_hrs_per_day" placeholder="Enter no of working hrs per day" name="no_of_working_hrs_per_day">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" >Total subject:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control"  placeholder="Enter total subject" name="total_subject">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" >No of subject per day:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control"  placeholder="Enter no of subject per day" name="no_of_subject_per_days">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" >Total hours for week:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control" id="total_hours_for_week"  placeholder="Enter no of subject per day" name="total_hours_for_week" readonly>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-4 col-sm-6">
        <button type="submit" class="btn btn-primary " disabled>Submit</button>
      </div>
    </div>
  </form>
  @else
  <div class="container">

    <div class="form-group">
      <label class="control-label col-sm-2" >Total no. of Subjects:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control"  id="total_hrs_of_each_subject" placeholder="Enter total hours of each subject" name="total_hours_of_each_subject">
      </div>
    </div>


 </div>
  <div class="" id="subject-section">
        <form id="subject-form">

        </form>
  </div>
    @endif
</div>
</body>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>

  <script type="text/javascript">
    $(function(){
            $('#no_of_working_hrs_per_day').keyup(function(){
               no_of_working_hrs_per_day = $('#no_of_working_hrs_per_day').val();

               total_hours_for_week = $('#no_of_working_days').val()*no_of_working_hrs_per_day
               console.log("total_hours_for_week")
               console.log(total_hours_for_week)

               $('#total_hours_for_week').val(total_hours_for_week);
               if (no_of_working_days != null && no_of_working_hrs_per_day != null) {
                $(':input[type="submit"]').prop('disabled', false);
               }
            });
         });
</script>

  <script type="text/javascript">
    $(function(){

      function getTotalHoursForWeek() {
          $.ajax({
            url: '{{url("/getTotalHoursForWeek")}}/',
            headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },   
            method: 'GET',
            type: 'JSON',
            contentType: false,
            cache: false,
            processData:false,
            success: function(obj) {
              console.log("obj")
              console.log(obj)
              return obj
            },
            error: function(obj) {
              return false;
            },

          }) 

      }

        $('#total_hrs_of_each_subject').on("keyup", function(){
           total_hrs_of_each_subject = $(this).val();
           // console.log("total_hrs_of_each_subject")
           // console.log(total_hrs_of_each_subject)
           
           $("form#subject-form").empty();
           for(i=0; i<total_hrs_of_each_subject;i++) {
            $("form#subject-form").append("<div class='row'><div class='form-group'><div class='col-sm-offset-1 col-sm-1'></div><div class='col-sm-4'><input data-id="+(i+1)+" type='text' class='form-control' name='subject[]' placeholder='Enter subject...'></div><div class='col-sm-4'><input data-id="+(i+1)+" type='number' class='form-control hours' name='hours[]' placeholder='hours...'></div></div><br/></div>");

          }
          $("form#subject-form").append("<input type='submit' id='generate-btn' class='btn btn-success' value='Generate' disabled>");
        });

        var total_hours_for_week_final = 0;
        var selected_field_count = 0;
        $(document).on("keyup", "#subject-section form input.hours" , function() { 

          total_hours_for_week = parseInt($(this).val())
          total_hours_for_week_final += total_hours_for_week;
          selected_field_count+=1

          console.log("sub total", total_hours_for_week_final)
          console.log("Auth", getTotalHoursForWeek())


          // if (total_hours_for_week_final == getTotalHoursForWeek() && $("#total_hrs_of_each_subject").val() == $(this).attr("data-id")) {
          if ($("#total_hrs_of_each_subject").val() == $(this).attr("data-id")) {
            $("#subject-section #generate-btn").removeAttr("disabled");          
          }
          // else {
          //   $('#mismatch-error').show()
          // }
        })

         });
</script>

  <script type="text/javascript">
      $(function() {
          
        $("#subject-form").on("submit", function(e) {
            e.preventDefault()
          $.ajax({
            url: '{{url("/savesubjects")}}',
            headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },   
            method: 'POST',
            type: 'JSON',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(obj) {
              console.log(obj)
              console.log(obj.status)
              $(".alert-danger").remove();
              if(obj.status ="success") {
                swal({
                      title:'An time table generated <b style="color:green;">successfully</b>!',
                      type:'success',

                      }).then(e=>{
                      window.location.href = "/time/table/generate"

                      }).catch(err=>{

                      });
                }
            },
            error: function(obj) {
              if (obj.status == 401) {
                swal(
                  'Warning',
                  'You are not Authorized!',
                  'warning'
                );
              }

            },

          }) 
      })       
  })
</script>

</html>
