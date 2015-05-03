<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- begin custom bootstrap styles -->
    <link href="ups/css/bootstrap-cls.css" rel="stylesheet" type="text/css" media="all" /><!-- end styles -->

    <!-- begin custom styles -->
    <link href="ups/css/styles.css" rel="stylesheet" type="text/css" media="all" /><!-- end styles -->
    <!-- begin upload javascript -->
    <script type="text/javascript" src="ups/js/ajax.js"></script><!-- end javascript -->


    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Загрузка файлов</title>

</head>
<body id="imup_body">

    <!-- begin logo -->
    <!--<a href="http://forum.sys-admin.kz/" class="logo"></a><!-- end logo -->

    <!-- begin content -->
    <div id="content" class="corners">

        <!-- begin form -->
        <form action="upload.php" method="post" name="image_upload" id="image_upload" enctype="multipart/form-data">

            <!-- begin image label and input -->
            <div class="left">
                <label>Поддерживаемы расширения:<br />(gif, jpg, png)</label>
            </div>
            <div class="right">

            <label>максимальный размер файла <strong>5Мб</strong></label><br />
            
                <input type="checkbox" name="tempimage" checked="checked"><label>Хранить 2 дня</label>
            
            </div>
            <!-- end image label and input -->

            <div class="cls row1"></div>
            <div class="cls border-top row1"></div>

            <!-- begin upload -->
            <span class="btn btn-default btn-file">
             Выбрать файл <input type="file" size="45" name="uploadfile" id="uploadfile" class="file margin_5_0" onchange="ajaxUpload(this.form);" />
            </span>
            <!-- end upload -->

         <div class="cls row2"></div>

         <!-- begin display uploaded image -->
         <div id="upload_area" class="corners align_center">
            <strong>Выберите изображение.</strong> Размер изображения минимум 10x10px, максимум 5000x5000px
        </div><!-- end display uploaded image -->

    </form><!-- end form -->

</div><!-- end content -->

</body>
</html>
