<template>
	<div class="add_region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    Редактировать Модель автобуса
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/busmodel"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveType" >
					<div class="row">
            <div class="form-group col-md-4">
              <label for="bustype_id">Категория автобуса</label>
              <select
                class="form-control input_style"
                v-model="form.bustype_id"
                :class="isRequired(form.bustype_id) ? 'isRequired' : ''"
                @change="selectTypeBus()"
              >
                <option value="" selected disabled>
                  Выберите категория автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getTypeofbusList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="name">Название класса</label>

              <select
                class="form-control input_style"
                v-model="form.tclass_id"
                :class="isRequired(form.tclass_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  Выберите тип автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getBusclassFindList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="busmodel_id">Марка автобуса</label>
              <select
                class="form-control input_style"
                v-model="form.busmarka_id"
                :class="isRequired(form.busmarka_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  Выберите тип автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getBusBrandList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="busmodel_id">Модель автобуса</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                placeholder="Название класса"
                v-model="form.name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-4">
              <label for="seat_from">Количество сидящих</label>
              <input
                type="number"
                class="form-control input_style"
                id="seat_from"
                placeholder="Количество сидящих"
                v-model="form.seat_from"
                :class="isRequired(form.seat_from) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-4">
              <label for="seat_to">Количество сидящих (по)</label>
              <input
                type="number"
                class="form-control input_style"
                id="seat_to"
                placeholder="Количество сидящих (по)"
                v-model="form.seat_to"
                :class="isRequired(form.seat_to) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-4">
              <label for="stay_from">Пассажировместимость </label>
              <input
                type="number"
                class="form-control input_style"
                id="stay_from"
                placeholder="Пассажировместимость"
                v-model="form.stay_from"
                :class="isRequired(form.stay_from) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-4">
              <label for="stay_to">Пассажировместимость (по)</label>
              <input
                type="number"
                class="form-control input_style"
                id="stay_to"
                placeholder="Пассажировместимость (по)"
                v-model="form.stay_to"
                :class="isRequired(form.stay_to) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-lg-10">
              <label for="stay_from">Комментарии </label>
              <textarea
                type="number"
                class="form-control input_style"
                id="stay_from"
                placeholder="Комментарии"
                v-model="form.desc"
                :class="isRequired(form.desc) ? 'isRequired' : ''"
              ></textarea>
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
    import Loader from '../../Loader'
	export default{
        components:{
            Loader
        },
		data(){
			return{
                laoding: true,
                form: {
                    name: "",
                    bustype_id: "",
                    tclass_id: "",
                    seat_from: "",
                    seat_to: "",
                    stay_from: "",
                    stay_to: "",
                    busmodel_id: "",
                    busmarka_id: "",
                    desc: "",
                },
				requiredInput:false
			}
		},
		computed:{
            ...mapGetters('busmodel',['getMassage','getBusmodel']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
            ...mapGetters("typeofbus", ["getTypeofbusList"]),
            ...mapGetters("busclass", ["getBusclassFindList"]),
		},
		async mounted(){
            await this.actionEditBusmodel(this.$route.params.busmodelId)
                await this.actionTypeofbusList();
            await this.actionBusBrandList();
            this.form = this.getBusmodel
            await this.actionBusclassFind({bustype_id: this.form.bustype_id});
            this.laoding = false
		},
		methods:{
            ...mapActions('busmodel',['actionEditBusmodel','actionUpdateBusmodel']),
            ...mapActions("busbrand", ["actionBusBrandList"]),
            ...mapActions("typeofbus", [
            "actionTypeofbusList",
            "actionDeleteTypeofbus",
            ]),
            ...mapActions("busclass", ["actionBusclassFind"]),
			isRequired(input){
	    		return this.requiredInput && input === '';
            },
            async selectTypeBus(){
                this.form.tclass_id = ''
                await this.actionBusclassFind({bustype_id: this.form.bustype_id});
            },
			async saveType(){
		    	if (
                    this.form.name != '' &&
                    this.form.bustype_id != '' &&
                    this.form.tclass_id != '' &&
                    this.form.seat_from != '' &&
                    this.form.seat_to != '' &&
                    this.form.stay_from != '' &&
                    this.form.stay_to != '' &&
                    this.form.busmodel_id != '' &&
                    this.form.busmarka_id != '' &&
                    this.form.desc != ''
                    ){
                    this.laoding = true
                    await this.actionUpdateBusmodel(this.form)
                    this.laoding = false
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
		    }
		}
	}
</script>
<style scoped>
	.saveBtn{
		margin-top:30px;
	}
</style>
