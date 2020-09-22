<template>
  	<form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
  		<h1>Yo'l kira haqi jadvali {{titulData.pass_number}} - sonli "{{titulData.name}}" </h1>
  		<div class="table-responsive">
	  		<table class="table table-bordered ">
	  			<thead>
	  				<tr>
	  					<th>№ т/р</th>
	  					<th>Бошлангич ва оралик охирги бекатлар номи</th>
	  					<th colspan="2">Масофа (км.)да</th>
	  				</tr>
	  				<tr>
	  					<th></th>
	  					<th></th>
	  					<th>Бошлангич бекатдан</th>
	  					<th>Бекатлар оралигида</th>
	  				</tr>
	  			</thead>
	  			<tbody>
	  				<tr v-for="(item,index) in items">
	  					<td>{{index+1}}</td>
	  					<td>{{item.whereForm.name}} - {{item.whereTo.name}}</td>
	  					<td>{{item.distance_from_start_station}}</td>
	  					<td>{{item.distance_between_station}}</td>
	  					<td>{{item.start_summ}}</td>
	  					<td v-for="(c,i) in item.count" v-if="c > 0">{{c}}</td>
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
					let tarif = 65
					let counts = this.titulData.timing_with
					let summ = 0
					counts.forEach((count,index)=>{
						index = index+1
						let arrItem = []
						if (index == 1) {
							summ = count.distance_from_start_station * tarif
							arrItem["start_summ"] = summ
							arrItem["id"] = count.id
							arrItem["whereForm"] = count.whereForm
							arrItem["whereTo"] = count.whereTo
							arrItem["distance_from_start_station"] = count.distance_from_start_station
							arrItem["distance_between_station"] = count.distance_between_station
							arrItem["count"] = [0]
							newItems.push(arrItem)
						}else {
							summ = count.distance_from_start_station * tarif
							arrItem["start_summ"] = summ
							arrItem["id"] = count.id
							arrItem["whereForm"] = count.whereForm
							arrItem["whereTo"] = count.whereTo
							arrItem["distance_from_start_station"] = count.distance_from_start_station
							arrItem["distance_between_station"] = count.distance_between_station
							arrItem["count"] = []
							for (var i = 1; i < index; i++){
								arrItem["count"].push(summ-newItems[i-1].start_summ)
							}
							newItems.push(arrItem)
						}
					})
					this.items = newItems
				}
			}
		},
		async mounted(){
			await this.actionEditDirection(this.$route.params.directionId);
		},
		computed:{
			...mapGetters("direction", ["getDirection"]),
		},
		methods:{
			...mapActions("direction", ["actionEditDirection"]),
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