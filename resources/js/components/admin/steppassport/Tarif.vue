<template>
  	<form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
  		<h1>Yo'l kira haqi jadvali {{titulData.pass_number}} - sonli "{{titulData.name}}" </h1>
  		<div class="table-responsive">
	  		<table class="table table-bordered ">
	  			<thead>
	  				<tr>
	  					<th>№ т/р</th>
	  					<th>Бошлангич ва оралик охирги бекатлар номи</th>
	  					<th :colspan="titulData.timing_with.length">Оралиқ ва сўнгги бекат номи ва тариф</th>
	  				</tr>
	  				<tr>
	  					<th v-for="(item,index) in titulData.timing_with"></th>
	  					<th v-for="(item,index) in titulData.timing_with">{{item.whereTo.name}}</th>
	  				</tr>
	  			</thead>
	  			<tbody>
	  				<tr v-for="(item,index) in titulData.timing_with">
	  					<td>{{index+1}}</td>
	  					<td>{{item.whereForm.name}}</td>
	  					<td>{{item.distance_from_start_station}}</td>
	  					<td>{{item.distance_between_station}}</td>
	  					<!-- <td>{{item.start_pass_summ}}</td> -->
	  					<!-- <td v-for="(c,i) in item.count" v-if="c.pass > 0">{{c.pass}} / {{c.weight}}</td> -->
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
					// for (var i = 0; i < numbers.length; i++) {
					// 	if (i>1) {
					// 		for (var k = 0; k <= i; k++) {
					// 			summ +=numbers[k]
					// 			newArr.push(summ)
					// 			// console.log(numbers[i])
					// 		}
					// 	}
					// }
					let newItems = []
					let tarif = 65
					let counts = this.titulData.timing_with
					let summ = 0
					counts.forEach((count,index)=>{
						index = index+1
						let arrItem = []
						if (index == 1) {
							summ = Math.round(count.distance_from_start_station) * tarif
							// arrItem["start_summ"] = summ
							// arrItem["id"] = count.id
							// arrItem["whereForm"] = count.whereForm
							// arrItem["whereTo"] = count.whereTo
							arrItem["distance_from_start_station"] = Number(count.distance_from_start_station)
							arrItem["distance_between_station"] = Number(count.distance_between_station)
							arrItem["count"] = [0]
							newItems.push(arrItem)
						}
						// else if (index == 2) {
						// 	summ = Math.round(count.distance_from_start_station) * tarif
						// 	// arrItem["start_summ"] = summ
						// 	// arrItem["id"] = count.id
						// 	// arrItem["whereForm"] = count.whereForm
						// 	// arrItem["whereTo"] = count.whereTo
						// 	arrItem["distance_from_start_station"] = Number(count.distance_from_start_station)
						// 	arrItem["distance_between_station"] = Number(count.distance_between_station)
						// 	arrItem["count"] = [Number(count.distance_between_station)]
						// 	newItems.push(arrItem)
						// }
						else {
							summ = Math.round(count.distance_from_start_station) * tarif
							// arrItem["start_summ"] = summ
							// arrItem["id"] = count.id
							// arrItem["whereForm"] = count.whereForm
							// arrItem["whereTo"] = count.whereTo
							arrItem["distance_from_start_station"] = Number(count.distance_from_start_station)
							arrItem["distance_between_station"] = Number(count.distance_between_station)
							arrItem["count"] = []
							for (var i = 0; i < numbers.length; i++) {
								if (i>1) {
									for (var k = 0; k <= i; k++) {
										summ +=numbers[k]
										newArr.push(summ)
										// console.log(numbers[i])
									}
								}
							}
							// for (var i = 1; i < index; i++){
							// 	arrItem["count"].push(summ+newItems[i-1].distance_between_station)
							// }
							newItems.push(arrItem)
						}
					})
					this.items = newItems
					console.log(this.items)
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
</style>