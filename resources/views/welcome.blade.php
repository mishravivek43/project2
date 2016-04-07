
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
          <form action='/verify' method='post'  >
<!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
    <!-- text input field -->
    <label for="url" id="" class="">URL</label>
    <input id="" class="" name="url" type="text" value="http://google.com">
    <!-- email input -->
    <!-- submit buttons -->
    <input type="submit" value="GET INFO">
    <!-- reset buttons -->
    <!--<input type="reset" value="Reset">-->
  </form>
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
    </body>
</html>
