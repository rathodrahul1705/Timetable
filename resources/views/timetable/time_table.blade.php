<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Time table</h2>
  <table class="table table-bordered" id="time_table">
    <thead>
      <tr>
      </tr>
    </thead>
    <tbody id="table_body">

    </tbody>
  </table>
</div>


<script type="text/javascript">
  $(function() {
    for(i=0;i<{{$total_cols}};i++) {
      $("#time_table thead tr").append('<th>Day '+(i+1)+'</th>')
    }
    cells = '';
    for(i=0;i<{{$total_rows}};i++) {
      // $("#time_table #table_body").empty()

          for(j=0;j<{{$total_cols}};j++) {
            cells += '<td>'+(j+1)+'</td>'
          }  
          $("#time_table #table_body").append('<tr>'+cells+'</tr>')
            console.log(cells)
    }


  })
</script>
</body>
</html>
