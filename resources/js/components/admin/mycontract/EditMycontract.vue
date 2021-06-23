<template>
	<div class="edit_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file-alt"></i>
				    Mening shartnomam
				</h4>
                <div class="d-flex">
                    <!-- <button type="button" class="btn btn-success mr-2" @click="activeContract">
                    	Активировать
                    </button> -->
                    <router-link class="btn btn-primary back_btn" to="/crm/mycontract">
                        <span class="peIcon pe-7s-back"></span>
                        {{$t('Orqaga')}}
                    </router-link>
                </div>
		  	</div>
		  	<div class="card-body">
		  		<div class="row">
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Номер контракта</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.number}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Статус</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.status}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Контракт тузилган санаси</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.date}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Контракт тугаш санаси</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.exp_date}}
		  				</div>
		  			</div>
		  		</div>
	  		</div>
		  	<div class="card-body">
		  		<div class="table table-responsive">
		  			<h2>Направления</h2>
			  		<table class="tab table-bordered table-hover" v-if="getUserMycontracts">
			  			<thead>
			  				<tr>
			  					<th>№</th>
			  					<th>Номер направления</th>
			  					<th>Название направления</th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				<tr v-for="(item,index) in getUserMycontracts.direction_ids" v-if="getUserMycontracts.direction_ids">
			  					<td width="5%">{{index+1}}</td>
			  					<td width="10%">{{item.pass_number}}</td>
			  					<td width="85%">{{item.name}}</td>
			  				</tr>
			  			</tbody>
			  		</table>
		  		</div>
		  	</div>
		  	<div class="card-body">
		  		<div class="table table-responsive">
		  			<h2>Мои авто</h2>
			  		<table class="tab table-bordered table-hover" v-if="getUserMycontracts">
			  			<thead>
			  				<tr>
			  					<th>Номер авто</th>
			  					<th>Категория авто</th>
			  					<th>Марка авто</th>
			  					<th>Модел авто</th>
			  					<th>Класс авто</th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				<tr v-for="(item,index) in getUserMycontracts.cars" v-if="getUserMycontracts.cars">
			  					<td>{{item.auto_number}}</td>
			  					<td>{{item.bustype ? item.bustype.name : ''}}</td>
			  					<td>{{item.busmarka ? item.busmarka.name : ''}}</td>
			  					<td>{{item.busmodel ? item.busmodel.name : ''}}</td>
			  					<td>{{item.tclass ? item.tclass.name : ''}}</td>
			  				</tr>
			  			</tbody>
			  		</table>
		  		</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	import Multiselect from 'vue-multiselect';
	import DatePicker from "vue2-datepicker";
	export default{
		components:{
			Loader,
			DatePicker,
			Multiselect,
		},
		data(){
			return{
				requiredInput:false,
				laoding: true,
			}
		},
		computed:{
			...mapGetters('typeofbus',['getTypeofbusList']),
            ...mapGetters('busmodel',['getBusmodelList', 'getBusmodelFindList']),
			...mapGetters('busclass',['getBusclassFindList']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
			...mapGetters('mycontract',[
				'getMassage',
				'getMycontractFind',
				'getUserMycontracts',
			]),
			...mapGetters('myprotocol',[
				'getMyprotocolFind',
			]),
			...mapGetters('user',[
				'getUserfindList',
			]),
			...mapGetters('direction',[
				'getDirectionFindList',
			]),
		},
		async mounted(){
			await this.actionEditMycontract(this.$route.params.mycontractId)
			console.log(this.getUserMycontracts)
			this.laoding = false
		},
		methods:{
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList', 'actionBusmodelListByBrand', 'actionBusmodelFindList']),
			...mapActions('busclass',['actionBusclassFind']),
            ...mapActions("busbrand",["actionBusBrandList"]),
			...mapActions('mycontract',[
				'actionEditMycontract',
				'actionUpdateMycontract',
				'actionMyprotocolFind',
				'actionDeleteMycontractCar',
                'actionContractActivate',
			]),
			...mapActions('oldprotocol',[
				'actionOldprotocolFind',
			]),
			...mapActions('user',[
				'ActionUserFind',
			]),
			...mapActions('direction',['actionDirectionFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		}
	}
</script>
<style scoped>
	.btn_save{
		margin-top: 40px;
	}
	.item_index{
	    margin: 30px 0 0 30px;
    	font-size: 23px;
	}
	.trash_car_item{
		margin: 30px 0 0 30px;
    	font-size: 23px;
    	color:#c73838;
    	cursor:pointer;
	}
</style>
