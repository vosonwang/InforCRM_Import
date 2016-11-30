<!DOCTYPE html>
<html>
<head>
    <title>Change AM</title>

    <script src="../../public/vm/changeAM.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h1>Change Account Manager</h1>
        <div id="CA">
            <input  placeholder="Please input Group name" v-model="GroupName">
            <select @change="getID($event)">
                <option value="">Choose AM</option>
                <template v-for="item in AM">
                    <option value="{{item.userid}}">{{item.username}}</option>
                </template>
            </select>

            <button class="btn btn-default" @click="changeAm">Change</button>
            <!--<button @click="reset">reset</button>-->
        </div>

        <p>1.input group name</p>
        <p>2.choose the accoutmanager that you want to change to </p>
        <p>3.click the change button </p>

        <h4>note:</h4>
        <p>You can only change the AccountManager of Account Group here</p>

    </div>


        <a href="/index.php/Upload" target="_blank">Click here to Import Data</a>

</div>

</body>
</html>