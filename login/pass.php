<section id="login">
	<div v-if="msgError !== null" class="alert alert-warning fadeInUp animated">
	   {{msgError}}
	   <button type="button" class="close" @click="msgError = null">
	      <span aria-hidden="true">&times;</span>
	   </button>
	</div>
	<div class="container">
	   <div class="card card-container">
        	<img class="profile-img-card" src="../assets/images/avatar_2x.png" />
        	<form class="form-signin" method="POST" action="" enctype="multipart/form-data" @submit.prevent="checkLogin">
            <input type="text" v-model="userDetails.username" class="form-control" placeholder="Tên đăng nhập" required>
            <input type="password" v-model="userDetails.password" class="form-control" placeholder="Mật khẩu cũ" required>
            <input type="password" v-model="userDetails.password1" class="form-control" placeholder="Mật khẩu mới" minlength="6" required>
            <input type="password" v-model="userDetails.password2" class="form-control" placeholder="Nhập lại mật khẩu mới" minlength="6" required>
            <button type="submit" class="btn btn-lg btn-primary btn-block btn-signin">Cập Nhật</button>
        	</form>
	   </div>
	   <div class="text-center">
	    	<a href="/login/index.php" class="dang-nhap"><i class="fa fa-long-arrow-left"></i>Quay lại đăng nhập</a>
	   </div>
	</div>
</section>
<script type="text/javascript">
var main = new Vue({
	el: '#login',
	data:{
		msgError: null,
		userDetails: {username: '', password: '', password1: '', password2: ''},
	},

	methods: {
		checkLogin: function(){
			let logForm = new FormData();

			logForm.append('username', this.userDetails.username);
			logForm.append('password', this.userDetails.password);
			logForm.append('password1', this.userDetails.password1);
			logForm.append('password2', this.userDetails.password2);

			axios.post('api/pass.php', logForm)
				.then(function(dataRes){

					if(dataRes.data.error){
						main.msgError = dataRes.data.message;
						console.log(main.msgError);

               	setTimeout(() => main.msgError = null, 3000);
					}
					else{
						window.location.href="index.php";
					}
				})
		}
	}
});
</script>