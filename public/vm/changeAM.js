$(function(){
	var test=new Vue({
		el:'#CA',
		data:{
			GroupName:"",
			AM:[],
			ACCOUNTMANAGERID:""
		},
		ready:function () {
			var _self=this;
			$.ajax({
				type:'get',
				url:'GetAMId',
				success:function(data){
					_self.AM = JSON.parse(data);
				}
			});
			
		},
		methods:{
			changeAm:function(){
				var _self=this;
				if(this.ACCOUNTMANAGERID=="" || this.GroupName==""){
					toastr.warning('please input group name and choose Account Manager!');
				}else {
					$.ajax({
						type:'post',
						url:'change',
						data:{json:{"GroupName":_self.GroupName,"ACCOUNTMANAGERID":_self.ACCOUNTMANAGERID}},
						success:function(data){
							if(data!="success"){
								toastr.error("Failed");
							}else {
								toastr.success(data);

							}
						}
					})
				}

			},
			getID:function(e){
				this.ACCOUNTMANAGERID=e.target.value;
			}
		}
	})
});
