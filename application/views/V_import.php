<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>导入新数据-步骤2</title>

    <script src="../../public/js/import.js"></script>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="jumbotron" style="margin-top: 30px;">
            <h1>导入数据</h1>

            <div id="data">
                <h2>表格名：{{filename}}</h2>
                <p v-if="row!=0">联系人：{{row}} 位</p>
                <p v-if="AccountNo!=0">公司：{{AccountNo}} 家</p>
                <input placeholder="请输入AccountId" v-model="AccountId" autocomplete="on">
                <input placeholder="请输入客户AddressID" v-model="AddressId">
                <input placeholder="请输入联系人AddressID" v-model="ConAddressId">
                <input placeholder="请输入ContactId" v-model="ContactId">
                <input placeholder="安全码" v-model="code" type="password">
                <button class="btn btn-default" @click="import">导入</button>

            </div>
            <a href="Upload" class="btn btn-default last-step" >上一步</a>

        </div>

    </div>
</div>

<!-- Small modal -->

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true" id="startImport">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect5"></div>
                <div class="rect4"></div>
            </div>
            <h4 style="margin: 10px auto;width: 150px;font-family: " Microsoft Yahei", Tahoma, Arial">导入中，请稍后...</h4>

        </div>
    </div>
</div>


</body>
</html>