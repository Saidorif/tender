<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    Добавить Модель автобуса
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/busmodel"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveType" >
					<div class="row">
                        <div class="form-group col-md-3">
                            <label for="busmodel_id">Марка автобуса</label>
                            <select
                                class="form-control input_style"
                                v-model="form.busbrand_id"
                                :class="isRequired(form.busbrand_id) ? 'isRequired' : ''"
                            >
                                <option value="" selected disabled>  Выберите тип автобус!  </option>
                                <option  :value="item.id" v-for="(item, index) in getBusBrandList">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
					  <div class="form-group col-md-3">
					    <label for="name">Модель автобуса</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	placeholder="Название"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-lg-3 d-flex justify-content-end saveBtn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	Сохранить
						</button>
				  	  </div>
					</div>
				</form>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		data(){
			return{
				form:{
                    name:'',
                    busbrand_id: ''
				},
				requiredInput:false
			}
		},
		computed:{
            ...mapGetters("typeofbus", ["getMassage", "getTypeofbusList"]),
            ...mapGetters('busmodel',['getMassage']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
		},
		async mounted(){
            await this.actionBusBrandList();
		},
		methods:{
            ...mapActions('busmodel',['actionAddBusmodel']),
            ...mapActions("busbrand", ["actionBusBrandList"]),
            ...mapActions("typeofbus", ["actionTypeofbusList", "actionDeleteTypeofbus"]),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveType(){
		    	if (this.form.name != ''){
					await this.actionAddBusmodel(this.form)
					if (this.getMassage.success) {
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						this.$router.push("/crm/busmodel");
						this.requiredInput = false
					}
				}else{
					this.requiredInput = true
				}
            },

		}
	}
</script>
<style scoped>
	.saveBtn{
		margin-top:30px;
	}
</style>
