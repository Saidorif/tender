<template>
  	<form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
  		<h1>Yo'l kira haqi jadvali {{titulData.pass_number}} - sonli "{{titulData.name}}" </h1>
  		<div class="table-responsive">
	  		<table class="table table-bordered ">
	  			<thead>
	  				<tr>
	  					<th>№ т/р</th>
	  					<th colspan="2">Бошлангич ва оралик охирги бекатлар номи</th>
	  					<th>Масофа (км.)да</th>
	  				</tr>
	  				<tr>
	  					<th></th>
	  					<th>Бошлангич бекатдан</th>
	  					<th>Бекатлар оралигида</th>
	  				</tr>
	  			</thead>
	  			<tbody>
	  				<tr v-for="(item,index) in titulData.timing_with">
	  					<td>{{item.whereForm.name}} - {{item.whereTo.name}}</td>
	  					<td>{{item.distance_from_start_station}}</td>
	  					<td>{{item.distance_between_station}}</td>
	  					<td v-for="count in index + 1">{{item.distance_between_station * 65	}}</td>
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
						if (index == 1) {
							let arrItem = []
							summ = count.distance_from_start_station * tarif
							arrItem["start_summ"] = summ
							arrItem["count"] = [0]
							newItems.push(arrItem)
						}
						// else if(index == 2) {
						// 	let arrItem = []
						// 	summ = count.distance_from_start_station * tarif
						// 	arrItem["start_summ"] = summ
						// 	arrItem["count"] = [(count.distance_between_station*tarif)]
						// 	// arrItem["numbers"].unshift(count.distance_between_station)
						// 	newItems.push(arrItem)
						// }
						else {
							let arrItem = []
							summ = count.distance_from_start_station * tarif
							arrItem["start_summ"] = summ
							arrItem["count"] = []
							arrItem["numbers"] = []
							newItems.forEach((val,i)=>{
								arrItem["count"].unshift((summ-val.start_summ))
								arrItem["numbers"].unshift(parseInt(count.distance_between_station))
							})
							newItems.push(arrItem)
						}
					})
					console.log(newItems)
				}
			}
		},
		mounted(){
		},
		computed:{
		},
		methods:{
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