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
				items:[]
			}
		},
		watch:{
			titulData:{
				handler(){
					let newItems = []
					let tarif = 20
					let tarifBagaj = 2500 /**2000**/
					
					let counts = this.titulData.timing_with
					let summ = 0
					counts.forEach((count,index)=>{
						let arrItem = []
						if (index == 1){
							summ = Math.round(count.distance_from_start_station) * tarif
							console.log(summ)
						}
						console.log(count.distance_from_start_station)
					})
				}
			}
		},
		async mounted(){
			await this.actionEditDirection(this.$route.params.directionId);
			await this.actionTarif(this.$route.params.directionId);
			console.log(this.getTarif)
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