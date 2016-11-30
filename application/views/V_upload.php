<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>导入新数据-步骤1</title>

    <script src="../../public/js/upload.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="jumbotron" style="margin-top: 30px;">
            <h1>上传Excel表格</h1>

            <div id="upload">
                <!--用来存放文件信息-->
                <div id="thelist" class="uploader-list"></div>
                <div id="picker" style="display: inline-block">选择文件</div>
                <button id="ctlBtn" class="btn btn-default">开始上传</button>
            </div>
            <h3>表格规范</h3>
            <ul style="padding-left: 0">
                <li>	文件大小不能超过5M。不能有空行，空行会导致文件过大。	</li>
                <li>	请按照模板上传。注意标题行的命名一定不能和模板有不同。	</li>
                <li>	标题行字段不可以缺失，如果有新增字段，请告知管理员。	</li>
                <li>	标题行留一行英文的即可	</li>
                <li>	新增一列AM（客户经理），在此处填入归属者。（可以每行不同）	</li>
                <li>	文件名不能有空格、特殊字符，只支持英文字母和下划线。	</li>
                <li>	尽量不要有空的列和行（有标题的列不算空列）	</li>

            </ul>
            <a href="Import" class="btn btn-default next-step" >下一步</a>
        </div>
    </div>
</div>

</body>
</html>