<template>
	<div class="add_area">
		<Loader v-if="laoding"/>
	    <div class="card card_with_tabs">
	  		<div class="card-header tabCard">
	    		<PassportTab/>
	  		</div>
	  		<div class="card-body">
				<div class="tarif_column"  v-if="titulData.type && titulData.type.id != 1">
					<div class="add_to_table">
					</div>
				  	<form class="row tabRow">
				  		<h1>Yo'l kira haqi jadvali {{titulData.pass_number}} - sonli "{{titulData.name}}" </h1>
				  		<div class="table-responsive" v-for="(t_item,t_index) in getTarif" v-if="t_item.tarif.status == 'approved'">
				  			<div class="d-flex align-items-center w-50 justify-content-between">
				  				<h4>{{t_index+1}})</h4>
				  				<div class="alert " :class="getStatusClass(t_item.tarif.status)">
				  					{{getStatusName(t_item.tarif.status)}}
				  				</div>
				  				<div class="">
				  					Сумма: <b>{{t_item.tarif.summa}}</b>
				  				</div>
				  				<div class="">
				  					Сумма багажа: <b>{{t_item.tarif.summa_bagaj}}</b>
				  				</div>
				  				<div class="">
				  					Дата тарифа: <b>{{t_item.tarif.created_at}}</b>
				  				</div>
				  			</div>
					  		<table class="table table-bordered ">
					  			<thead>
					  				<tr>
					  					<th>№ т/р</th>
					  					<th>Бошлангич ва оралик охирги бекатлар номи</th>
					  					<template :colspan="titulData.timing_with.length" v-for="(item,index) in titulData.timing_with">
						  					<th>
							  					{{item.whereTo.name}}
							  				</th>
					  					</template>
					  				</tr>
					  			</thead>
					  			<tbody>
					  				<tr v-for="(items,index) in t_item.items">
					  					<td>{{index+1}}</td>
					  					<td>{{items[index].from_name ? items[index].from_name : ''}}</td>
					  					<template v-for="(item,key) in items">
					  						<td v-if="item.tarif" :class="key == items.length - 1 && index == 0 ? 'alert-danger' : ''">
					  							<div class="tarifs tarif">
					  								<b>{{item.tarif}}</b>
					  							</div>
					  							<div class="tarifs tarif_bagaj">
					  								<b>{{item.tarif_bagaj}}</b>
					  							</div>
					  							<div class="tarifs tarif_bagaj">
					  								<b>{{item.distance_test}}KM</b>
					  							</div>
					  						</td>
					  						<template v-else >
						  						<td class="has_no_name_tarif" v-if="key !='ddd'"></td>
					  						</template>
					  					</template>
					  				</tr>
					  			</tbody>
					  		</table>
				  		</div>
					</form>
				</div>
		  	</div>
		</div>
   </div>
</template>
<script>
	import {mapGetters , mapActions} from 'vuex'
	import PassportTab from "./PassportTab";
import Loader from '../../Loader'

	export default{
		components: {
			PassportTab,
			Loader
	  	},
		data(){
			return{
				items:[],
				titulData:[],
				form:{
					user_id:1,
					summa:''
				},
				confirm:{
					summa:'',
					summa_bagaj:'',
				},
				requiredInput: false,
				laoding: true,
			}
		},
		watch:{
			titulData:{
				handler(){
					// let numbers = [109,118,102]
					// let newArr = [];
					// let summ = 0;
					// for (var i = 0; i < numbers.length; i++) {
					// 	if (i>1) {
					// 		for (var k = 0; k <= i; k++) {
					// 			summ +=numbers[k]
					// 			newArr.push(summ)
					// 		}
					// 	}
					// }

					// let newItems = []
					// let tarif = 65

					// let counts = this.titulData.timing_with
					// let summ = 0
					// let summar = 0
					// counts.forEach((count,index)=>{
					// 	index = index+1
					// 	let arrItem = []
					// 	if (index == 1){
					// 		summ = Math.round(count.distance_from_start_station) * tarif
					// 		arrItem["start_pass_summ"] = summ
					// 		arrItem["id"] = count.id
					// 		arrItem["whereForm"] = count.whereForm
					// 		arrItem["whereTo"] = count.whereTo
					// 		arrItem["distance_from_start_station"] = count.distance_from_start_station
					// 		arrItem["distance_between_station"] = Number(count.distance_between_station)
					// 		arrItem["count"] = [0]
					// 		newItems.push(arrItem)
					// 	}else{
					// 		summ = Math.round(count.distance_from_start_station) * tarif
					// 		arrItem["start_pass_summ"] = summ
					// 		arrItem["id"] = count.id
					// 		arrItem["whereForm"] = count.whereForm
					// 		arrItem["whereTo"] = count.whereTo
					// 		arrItem["distance_from_start_station"] = count.distance_from_start_station
					// 		arrItem["distance_between_station"] = Number(count.distance_between_station)
					// 		arrItem["count"] = []
					// 		// for (var i = 0; i < numbers.length; i++) {
					// 		// 	if (i>1) {
					// 		// 		for (var k = 1; k <= i; k++) {
					// 		// 			summ +=numbers[k]
					// 		// 			newArr.push(summ)
					// 		// 		}
					// 		// 	}
					// 		// }
					// 		// for (var i = 0; i <= index; i++){
					// 		// 	if (i>1) {
					// 		// 		arrItem["count"].push(Number(count.distance_between_station)+Number(newItems[index-i].distance_between_station))
					// 		// 	}
					// 		// }
					// 			let myNum = 0
					// 		newItems.forEach((s_item, s_index)=>{
					// 			if (s_index>0) {
					// 				myNum += Number(newItems[index-s_index - 1].distance_between_station)
					// 				arrItem["count"].push(myNum)
					// 			}
					// 		})
					// 		newItems.push(arrItem)
					// 	}
					// })
					// this.items = newItems
				}
			}
		},
		async mounted(){
			await this.actionEditDirection(this.$route.params.directionId);
			await this.actionTarif(this.$route.params.directionId);
			this.titulData = this.getDirection
			this.laoding = false
		},
		computed:{
			...mapGetters("direction", ["getDirection"]),
			...mapGetters("passportTab", ["getTarif",'getMsg']),
		},
		methods:{
			...mapActions("passportTab", ["actionTarif",'actionTarifConfirm']),
			...mapActions("direction", ["actionEditDirection"]),
			isRequired(input) {
		      return this.requiredInput && input === "";
		    },
		    getStatusClass(status){
		    	if (status == 'pending') {
		    		return 'alert-warning'
		    	}else{
		    		return 'alert-primary'
		    	}
		    },
		    getStatusName(status){
		    	if (status == 'pending') {
		    		return 'В ожидании!'
		    	}else if(status == 'approved'){
		    		return 'Подвержден!'
		    	}else{
		    		return status
		    	}
		    },
			async sendTarif(){
				if (this.confirm.summa != '' && this.confirm.summa_bagaj != ''){
					let data = {
						id:this.$route.params.directionId,
						summa:this.confirm.summa,
						summa_bagaj:this.confirm.summa_bagaj,
                    }
                    this.laoding = true
                    await this.actionTarifConfirm(data)
                    this.laoding = false
					if (this.getMsg.success){
			          	await this.actionTarif(this.$route.params.directionId);
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMsg.message
			          	});
					}
					this.confirm.summa = ''
					this.confirm.summa_bagaj = ''
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
			},
			addToTable(){
				if(this.form.user_id != '' && this.form.summa != ''){

				}
			},
			checkNumber(number){
				let weightTarif1 = 45
				let weightTarif2 = 40
				if (number/100 <= 1) {
					return weightTarif1
				}else if(number/100 > 1){
					return weightTarif1 + weightTarif2
				}
			},
			saveData(){
				if(this.form.user_id != '' && this.form.summa != ''){

				}
			}
		}
	}
</script>
<style scoped>
	.tabRow {
	  padding-left: 30px;
	  padding-right: 30px;
	}
	.tarifs{
		display:flex;
		justify-content: center;
	}
	.tarif{
		color:#a81a00;
	}
	.tarif_bagaj{
		color:#324841;
	}
	.has_no_name_tarif{
	    background: #9a9a9a;
	}
	.add_to_table{
	    margin-bottom:40px;
	}
	.confirm_tarif_default{
	    display: flex;
	    justify-content: flex-end;
	    align-items: center;
	}
	.confirm_tarif_default .btn{
		margin-left:20px;
		margin-top:10px;
	}
</style>
