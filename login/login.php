<section id="login">
	<div class="container">
	    <div class="card card-container">
	        <img class="profile-img-card" src="../assets/images/avatar_2x.png" />
	        <form class="form-signin" method="POST" action="" enctype="multipart/form-data" @submit.prevent="checkLogin">
	            <input type="text"  	v-model="userDetails.username" class="form-control" placeholder="Tài khoản" required>
	            <input type="password" 	v-model="userDetails.password" class="form-control" placeholder="Mật khẩu" required>
	            <button type="submit" class="btn btn-lg btn-primary btn-block btn-signin">Đăng Nhập</button>
	        </form>
	    </div>
	    <div class="text-center">
	    	<a href="/login/index.php?view=pass" class="dang-nhap"><i class="fa fa-key"></i>Đổi Mật Khẩu</a>
	    </div>
	</div>
</section>
<script type="text/javascript">
var main = new Vue({
	el: '#login',
	data:{
		msgSuccess: "",
		msgError: "",
		userDetails: {username: '', password: ''},
		phongban: "",
	},

	methods: {
		checkLogin: function(){
			let logForm = new FormData();

			logForm.append('username', this.userDetails.username);
			logForm.append('password', this.userDetails.password);

			axios.post('api/login.php', logForm)
				.then(function(dataRes){

					if(dataRes.data.error){
						main.msgError = dataRes.data.message;
						console.log(main.msgError);
					}
					else{
						main.msgSuccess = dataRes.data.message;
						main.phongban   = dataRes.data.phongban;
						main.userDetails= {username: '', password: ''};

						console.log(dataRes.data);
						console.log(main.msgSuccess);

						window.location.href="../index.php?view=" + main.phongban;
					}
				});
		}

	}
});
</script>