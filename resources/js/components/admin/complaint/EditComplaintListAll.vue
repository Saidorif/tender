<template>
	<div class="add_cont">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    Добавить вариант обращения
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/complaint-list"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
	  			<div class="row">
			  		<div class="form-group col-md-4">
					    <label for="name">Направление</label>
					    <multiselect
			                :value="filter.name"
			                :options="getDirectionFindList"
			                @search-change="value => filterVariantList(value)"
			                v-model="filter.name"
			                placeholder="Найдите направление!"
			                :searchable="true"
			                track-by="id"
			                label="name"
			                :max="3"
			                :loading="isLoading"
			                selectLabel="Нажмите Enter, чтобы выбрать"
			                deselectLabel="Нажмите Enter, чтобы удалить"
			                :option="[{name: '', id: 1}]"
			                @select="dispatchAction"
			                :disabled="btnShow"
		                >
		                <span slot="noResult">По вашему запросу ничего не найдено</span>
		                <span slot="noOptions">Cписок пустой</span>
		                </multiselect>
				  	</div>
				  	<div class="form-group col-md-4">
					    <label for="status">Резултат</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.status"
					    	:class="isRequired(form.status) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>Выберите резултат!</option>
					    	<option value="active">Не подтвержден</option>
					    	<option value="completed">Подтвержден</option>
					    </select>
				  	</div>
			  		<div class="form-group col-md-4 download_file">
			  			<label for="file">Файл</label>
					    <div class="input-group">
			                <input
			                  type="file"
			                  id="file"
			                  class="form-control"
			                  @change="changeFile($event)"
			                  :disabled="btnShow"
			                />
		              	</div>
		              	<div class="d-flex justify-content-end">
					     	<a
					     		:href="getComplaintEditListAll.comment_file"
					     		title="Скачать"
					     		class="donwload_text"
					     		download
					     		v-if="getComplaintEditListAll.comment_file"
				     		>
						     	<b>Посмотреть <i class="fas fa-eye"></i></b>
					     	</a>
		              	</div>
				  	</div>
			  		<div class="form-group col-md-12">
			  			<label for="file">Комментарий</label>
					    <div class="input-group">
			                <textarea
			                    v-model="form.comment"
			                    class="form-control"
			                    placeholder="Текст"
			                    :disabled="btnShow"
			                    :class="isRequired(form.comment) ? 'isRequired' : ''"
		                    ></textarea>
		              	</div>
				  	</div>
	  			</div>
		  		<form>
					<div class="row">
					  <div class="form-group col-md-6">
					    <label for="fio">Ф.И.О</label>
					    <div class="input_style input_text form-control">
					     	{{getComplaintEditListAll.surname}}{{getComplaintEditListAll.name}}{{getComplaintEditListAll.middlename}}
				     	</div>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="phone">Телефон</label>
					    <div class="input_style input_text form-control">
					     	{{getComplaintEditListAll.phone}}
				     	</div>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="text">Сообщение</label>
					    <div class="input_style input_text form-control">
					     	{{getComplaintEditListAll.text}}
				     	</div>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="file">Файл</label>
				     	<a :href="getComplaintEditListAll.file" title="Скачать" class="donwload_text" download>
						    <div class="input_style input_text form-control">
						     	Посмотреть <i class="fas fa-eye"></i>
					     	</div>
				     	</a>
					  </div>
					  <div class="form-group col-lg-12 d-flex justify-content-end">
					  	<button type="submit" class="btn btn-primary btn_save_category" @click.prevent="connectComplt" v-if="btnShow">
					  		<i class="far fa-plus-square"></i>
						  	Прикрепить
						</button>
					  	<button type="submit" class="btn btn-primary btn_save_category" @click.prevent="saveComplt" v-else>
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
	import Multiselect from 'vue-multiselect';
    import {mapActions, mapGetters} from 'vuex'
    import Loader from '../../Loader'
	export default{
		components: {
            Multiselect,
            Loader
	  	},
		data(){
			return{
				form:{
					direction_id:'',
					status:'',
					comment:'',
					comment_file:'',
				},
				filter:{
					id:'',
					name:'',
				},
				requiredInput:false,
                isLoading:false,
                laoding: true,
				btnShow:true
			}
		},
		computed:{
			...mapGetters("direction", ["getMassage","getDirectionFindList"]),
			...mapGetters('complaint',['getMassage','getComplaintEditListAll'])
		},
		async mounted(){
            await this.actionComplaintEditListAll(this.$route.params.complaintListAllId)
            this.laoding = false
			if(this.getComplaintEditListAll.status == 'active'){
				this.form = this.getComplaintEditListAll
				this.filter.name = this.getComplaintEditListAll.direction
			}
		},
		methods:{
			...mapActions("direction", ["actionDirectionFind"]),
			...mapActions('complaint',['actionComplaintUpdateListAll','actionComplaintEditListAll']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async filterVariantList(value){
		      if(value != ''){
		        this.isLoading = true
		        setTimeout(()=>{
		          this.actionDirectionFind({name: value})
		        this.isLoading = false
		        },1000)
		      }
		    },
		    dispatchAction(data){
		      this.form.direction_id =  data.id;
		    },
		    connectComplt(){
		    	this.btnShow = false
		    },
		    changeFile(event) {
		      let file = event.target.files[0];
		      if (file.size > 1048576) {
		        swal.fire({
		          type: "error",
		          icon: "error",
		          title: "Ошибка",
		          text: "Размер файл не должно быть больше 1мб"
		        });
		      } else {
		        this.form.comment_file = event.target.files[0];
		      }
		    },
		    async saveComplt(){
		    	if (this.form.direction_id != '' && this.form.comment != '' && this.form.status != ''){
		    		let formData = new FormData();
			        formData.append('direction_id', this.form.direction_id);
			        formData.append('status', this.form.status);
			        formData.append('comment', this.form.comment);
			        formData.append('comment_file', this.form.comment_file);
			        let data = {
			        	items:formData,
			        	id:this.$route.params.complaintListAllId
                    }
                    this.laoding = true
                    await this.actionComplaintUpdateListAll(data)
                    this.laoding = false
					this.$router.push("/crm/complaint-list");
					this.requiredInput =false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Данный сохранен!',
				    })
				}else{
					this.requiredInput =true
				}
		    }
		}
	}
</script>
<style scoped>
	.donwload_text .input_style.input_text.form-control{
		transition:0.3s;
	}
	.donwload_text{
		text-decoration:none;
	}
	.donwload_text .input_style.input_text.form-control:hover{
		background-color:#bae8e0 !important;
	}
	.download_file .input-group{
		margin-bottom: 0px;
	}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
