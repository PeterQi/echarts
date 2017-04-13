<?php
    if(isset($_FILES["csv_file"]))
    {
        move_uploaded_file($_FILES["csv_file"]["tmp_name"], "upload/".$_FILES["csv_file"]["name"]);
        $file = fopen("upload/".$_FILES["csv_file"]["name"], "r");
        if ($_POST["table_type"]=="bar") {
            $data = Array();
            $i = 0;
            while ($line = fgetcsv($file))
            {
                $data[] = $line;
                $i++;
            }
            $col_count = count($data[0]);
            $row_count = $i;
            $obj = new stdClass;
            if ($col_count >= $row_count) {
                $real_data = Array();
                for ($j = 0; $j < $row_count; $j++) {
                    $real_data[] = Array();
                    for ($k = 0; $k < $col_count; $k++) {
                        $real_data[$j][] = mb_convert_encoding($data[$j][$k], "UTF-8", "gb2312");
                    }
                }
                if (is_numeric($data[1][0])) {
                    $obj -> legend = Array();
                } else {
                    for ($k = 0; $k < $row_count; $k++) {
                        array_splice($real_data[$k], 0, 1);
                    }
                    $legend = Array();
                    for ($j = 0; $j < $row_count; $j++) {
                        $legend[] = mb_convert_encoding($data[$j][0], "UTF-8", "gb2312");
                    }
                    $obj -> legend = $legend;
                }
                if (is_numeric($data[0][1])) {
                    $obj -> category = Array();
                } else {
                    array_splice($real_data, 0, 1);
                    $category = Array();
                    for ($j = 0; $j < $col_count; $j++) {
                        $category[] = mb_convert_encoding($data[0][$j], "UTF-8", "gb2312");
                    }
                    $obj -> category = $category;
                }
                $obj -> data = $real_data;
            } else {
                $real_data = Array();
                for ($j = 0; $j < $col_count; $j++) {
                    $real_data[] = Array();
                    for ($k = 0; $k < $row_count; $k++) {
                        $real_data[$j][] = mb_convert_encoding($data[$k][$j], "UTF-8", "gb2312");
                    }
                }
                if (is_numeric($data[0][1])) {
                    $obj -> legend = Array();
                } else {
                    for ($k = 0; $k < $col_count; $k++) {
                        array_splice($real_data[$k], 0, 1);
                    }
                    $legend = Array();
                    for ($j = 0; $j < $col_count; $j++) {
                        $legend[] = mb_convert_encoding($data[0][$j], "UTF-8", "gb2312");
                    }
                    $obj -> legend = $legend;
                }
                if (is_numeric($data[1][0])) {
                    $obj -> category = Array();
                } else {
                    array_splice($real_data, 0, 1);
                    $category = Array();
                    for ($j = 0; $j < $row_count; $j++) {
                        $category[] = mb_convert_encoding($data[$j][0], "UTF-8", "gb2312");
                    }
                    $obj -> category = $category;
                }
                $obj -> data = $real_data;
            }
            echo json_encode($obj);
        }
        fclose($file);
    } else {
      echo "NO";
    }
?>