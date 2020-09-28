<template>
  	<form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
  		<h1>Yo'l kira haqi jadvali {{titulData.pass_number}} - sonli "{{titulData.name}}" </h1>
  		<div class="table-responsive">
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
	  				<tr v-for="(items,index) in getTarif">
	  					<td>{{index+1}}</td>
	  					<td>{{items[index].from_name}}</td>
	  					<template v-for="(item,key) in items">
	  						<td v-if="item.tarif">
	  							<div class="tarifs tarif">
	  								<b>{{item.tarif}}</b>
	  							</div>
	  							<div class="tarifs tarif_bagaj">
	  								<b>{{item.tarif_bagaj}}</b>
	  							</div>
	  						</td>
	  						<td v-else class="has_no_name_tarif"></td>
	  					</template>
	  				</tr>
	  			</tbody>
	  		</table>
  		</div>
	</form>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		props:['titulData'],
		data(){
			return{
				items:[],
			}
		},
		watch:{
			titulData:{
				handler(){
					console.log(this.getTarif)
					// let numbers = [109,118,102]
					// let newArr = [];
					// let summ = 0;
					// for (var i = 0; i < numbers.length; i++) {
					// 	if (i>1) {
					// 		for (var k = 0; k <= i; k++) {
					// 			summ +=numbers[k]
					// 			newArr.push(summ)
					// 			// console.log(numbers[i])
					// 		}
					// 	}
					// }
					// console.log(newArr)

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
					// 		// 			// console.log(numbers[i])
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
					// 				// console.log(myNum)
					// 			}
					// 		})
					// 		// console.log('+++')
					// 		newItems.push(arrItem)
					// 	}
					// })
					// this.items = newItems
					// console.log(this.items)
				}
			}
		},

		async mounted(){
			await this.actionEditDirection(this.$route.params.directionId);
			await this.actionTarif(this.$route.params.directionId);
		},
		computed:{
			...mapGetters("direction", ["getDirection"]),
			...mapGetters("passportTab", ["getTarif"]),
		},
		methods:{
			...mapActions("passportTab", ["actionTarif"]),
			...mapActions("direction", ["actionEditDirection"]),
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
</style>