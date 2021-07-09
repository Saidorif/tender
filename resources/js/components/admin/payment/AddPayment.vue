<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				    {{$t('Qoʼshish')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/payment"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="savePayment" >
					<div class="row">
					  <div class="form-group col-xl-3 col-xl-6">
					    <label for="name">{{$t('Tashkilot nomi')}}</label>
					    <multiselect
							:value="values"
							:options="findList"
							@search-change="value => findCompany(value)"
							v-model="values"
	                        :searchable="true"
	                        track-by="id"
	                        label="company_name"
	                        :max="3"
							:loading="isLoading"
							:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
							:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
							:option="[]"
							:class="isRequired(form.inn) ? 'isRequired' : ''"
							@select="dispatchAction"
							@remove="removeInn"
							>
							<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
							<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
						</multiselect>
					  </div>
					  <div class="form-group col-xl-2">
					    <label for="summ">{{$t('Miqdor')}}</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="summ"
					    	v-model="form.summ"
					    	:class="isRequired(form.summ) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-xl-2">
					    <label for="date">{{$t('Sana')}}</label>
					    <input
					    	type="date"
					    	class="form-control input_style"
					    	id="date"
					    	v-model="form.date"
					    	:class="isRequired(form.date) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-xl-3 col-xl-6">
					    <label for="details">{{$t('Tafsilotlar')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="details"
					    	v-model="form.details"
					    	:class="isRequired(form.details) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-xl-2 form_btn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{$t('Saqlash')}}
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
	import Multiselect from 'vue-multiselect';
	import Loader from '../../Loader'
	export default{
		components:{
			Loader,
			Multiselect,
		},
		data(){
			return{
				form:{
					inn:'',
					summ:'',
					date:'',
					details:'',
				},
				requiredInput:false,
				laoding: true,
				isLoading: true,
				findList:[],
				values:[],
			}
		},
		computed:{
			...mapGetters('payment',['getMassage']),
			...mapGetters('find',['getFindByCompanies']),
		},
		mounted(){
			this.laoding = false
			this.isLoading = false
		},
		methods:{
			...mapActions('payment',['actionAddPayment']),
			...mapActions('find',['actionFindByCompanies']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async findCompany(value){
		      if(value != ''){
		        this.isLoading = true
		        await setTimeout(async ()=>{
					await this.actionFindByCompanies({name: value})
			        this.findList =  this.getFindByCompanies ? this.getFindByCompanies : []
		        this.isLoading = false
		        },1000)
		      }
		    },
		    async dispatchAction(data){
		    	this.form.inn = data.inn
		    },
		    removeInn(){
		    	this.form.inn = ''
		    	this.findList = []
		    },
			async savePayment(){
		    	if (this.form.date != '' && this.form.inn != '' && this.form.summ != '' && this.form.details != ''){
					this.laoding = true
					await this.actionAddPayment(this.form)
                    this.laoding = false
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })

						this.$router.push("/crm/payment");
						this.requiredInput = false
					}
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
