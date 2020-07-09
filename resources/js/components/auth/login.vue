<template>
	<div class="card lognCard">
	    <div class="card-body login-card-body">
			<div class="login_alert" v-if="errorMsg"><i class="fas fa-exclamation-circle mr-2"></i> Неверный логин  или пароль </div>
			<div class="col-md-6 auth_tab_block">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Логин</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Зарегистрироваться</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						<div class="form_content">
							<p class="login_title"> Вход в персональный кабинет</p>
							<form @submit.enter.prevent="onSubmit">
								<div class="input-group">
									<input type="email" class="form-control" placeholder="Email" v-model="form.email">
									<div class="input-group-append">
										<div class="input-group-text">
											<img src="/img/user.png" alt="">
										</div>
									</div>
								</div>
								<div class="input-group">
									<input type="password" class="form-control" placeholder="Пароль" v-model="form.password">
									<div class="input-group-append">
										<div class="input-group-text">
											<img src="/img/key.png" alt="">
										</div>
									</div>
								</div>
								<div class="row">
									<!-- /.col -->
									<div class="col-12">
										<button type="submit" class="btn btn-primary btn-block">Войти</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
						</div>
					</div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
						<div class="form_content auth_request">
							<form @submit.enter.prevent="onSubmit">
								<div class="col-md-6">
									<div class="input-group">
										<input type="email" class="form-control" placeholder="Email" v-model="form.email">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/user.png" alt="">
											</div>
										</div>
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="inn" v-model="form.inn">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="fio" v-model="form.fio">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="company_name" v-model="form.company_name">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<input type="password" class="form-control" placeholder="letncesNumber" v-model="form.letncesNumber">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="bank_number" v-model="form.bank_number">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="mfo" v-model="form.mfo">
										<div class="input-group-append">
											<div class="input-group-text">
												<img src="/img/key.png" alt="">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<!-- /.col -->
									<div class="col-12">
										<button type="submit" class="btn btn-primary btn-block">Войти</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6" style="position:unset;">
				<div class="circle_bg"></div>
				<div class="circle_bg_scaled"></div>
				<div class="circle_bg_scaled_2"></div>
			</div>
	    </div>
  	</div>
</template>
<script>
	import { mapActions, mapGetters } from "vuex";
	import { TokenService } from "./../../services/storage.service";
	export default{
		data() {
		    return {
		      form: {
		        email: "",
		        password: ""
			  },
			  errorMsg: null
		    };
	  	},
	 	computed: {
		    ...mapGetters(["authenticationErrorCode","authenticationError"])
	  	},
	  	async mounted(){
	  		
	  	},
	  	methods: {
		    ...mapActions(["login"]),
		    async onSubmit(){
		      this.$Progress.start();
		      if (this.form.email != "" && this.form.password != "") {
		        await this.login(this.form);
		        await this.authenticationErrorCode;
		        if (!this.authenticationErrorCode){
		          toast.fire({
					type: "success",
					icon: 'success',
		            title: "Вошли в систему!"
		          });
		          this.$Progress.finish();
		          // setTimeout(()=>{
		          // 	window.location = '/crm/dashboard';
		          // },100)
				//   this.$router.push("/crm/dashboard");
				  window.location.href = "/crm/dashboard";
		        }else{
					this.errorMsg = this.authenticationError
				  	this.$Progress.fail();

		        }
		      }
		    }
	  	},
	}
</script>
<style scoped>

</style>