/**
 * Created by voson on 2016/11/25.
 */
jQuery(function () {
    var data = new Vue({
        el: '#data',
        data: {
            row: "",
            AccountNo: 0,
            AccountId: "",
            ContactId: "",
            AddressId: "",
            ConAddressId:"",
            //安全码
            code:"",
            filename:""
        },
        ready:function () {
            var _self=this;
            this.filename=getCookie('filename');
            $.ajax({
                type: 'post',
                url: 'Import/getMsg',
                success: function (data) {
                    if(data==0){
                        toastr.error('上传的文件不存在！')
                    }else{
                        if((JSON.parse(data))[1]>0){
                            _self.row=(JSON.parse(data))[0];
                            _self.AccountNo=_self.row-(JSON.parse(data))[1];
                        }else{
                            toastr.error('公司名不存在！')
                        }
                    }


                },
                error: function (data) {
                    console.log(data);
                }
            })

        },
        methods: {
            import: function () {
                if (this.AccountId != "" && this.ContactId != "" && this.AddressId != "") {
                    var _self = this;

                    $.ajax({
                        type: 'post',
                        url: 'Import/getData',
                        data: {AccountId: JSON.stringify(_self.AccountId), ContactId: JSON.stringify(_self.ContactId),AddressId:JSON.stringify(_self.AddressId),ConAddressId:JSON.stringify(_self.ConAddressId),code:_self.code},
                        beforeSend: function () {
                            $('#startImport').modal('show');
                        },
                        success: function (data) {
                            toastr.success('导入成功!');
                        },
                        error: function (data) {
                            switch(data){
                                case 1001:
                                toastr.warning('安全码错误！');
                                break;
                                case 1002:
                                toastr.warning('客户经理或者销售线索不能为空!');
                                break;
                                case 1003:
                                toastr.warning('公司名不能为空!');
                                break;
                                case 1004:
                                toastr.warning('文件不存在!');
                                break;
                                default:
                                 toastr.error('导入失败！请联系管理员');
                            }
                        },
                        complete: function (data) {
                            $('#startImport').modal('hide');
                        }
                    })
                } else {
                    toastr.warning("请输入三项ID！")
                }
            }
        }
    });
});
