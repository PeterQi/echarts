<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>
  <body>
    <form action="data.php" method = "post" enctype="multipart/form-data">
      <input type = "file" name = "csv_file"/>
      <select name = "table_type">
        <option value = "bar">bar</option>
        <option value = "line">line</option>
      </select>
      <input type = "submit"/>
    </form>
  </body>
</html>