<template>
	<div class="add_area">
		<Loader v-if="laoding"/>
	    <PassportTab/>
	  	<div class="card-body container">
				<div class="tarif_column">
			  		<h1>{{$t('Yoʼl kira haqi jadvali')}} {{titulData.pass_number}} - {{$t('sonli')}} "{{titulData.name}}" </h1>
			  		<div class="table-responsive">
				  		<div class="table-responsive" v-for="(t_item,t_index) in getTimingtarif">
				  			<div class="d-flex align-items-center w-50 justify-content-between">
				  				<h4>{{t_index+1}})</h4>
				  				<div class="">
				  					{{$t('Miqdor')}}: <b>{{t_item.tarif.summa}}</b>
				  				</div>
				  				<div class="">
				  					{{$t('Bagaj miqdori')}}: <b>{{t_item.tarif.summa_bagaj}}</b>
				  				</div>
				  				<div class="">
				  					{{$t('Tarif sanasi')}}: <b>{{t_item.tarif.created_at}}</b>
				  				</div>
				  			</div>
					  		<table class="table table-bordered ">
					  			<thead>
					  				<tr>
					  					<th>№ т/р</th>
					  					<th>{{$t('Boshlangʼich va oraliq oxirgi bekatlar nomi')}}</th>
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
					  								<b>{{item.distance_test}}{{$t('km')}}</b>
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
			  		</div>
				</div>
		</div>
   </div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import PassportTab from "./PassportTab";
import Loader from '../Loader'

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
				laoding: true
			}
		},
		async mounted(){
			await this.actionDirection(this.$route.params.directionId);
			await this.actionTimingtarif(this.$route.params.directionId);
			this.titulData = this.getDirection
			this.laoding = false
		},
		computed:{
			...mapGetters("front", ["getTimingtarif", "getDirection"]),
		},
		methods:{
			...mapActions("front", ["actionTimingtarif", "actionDirection"]),
            getStatusClass(status){
		    	if (status == 'pending') {
		    		return 'alert-warning'
		    	}else{
		    		return 'alert-primary'
		    	}
		    },
             getStatusName(status){
		    	if (status == 'pending') {
		    		return this.$t('Kutish jarayonida');
		    	}else if(status == 'approved'){
		    		return this.$t('Tasdiqlangan')
		    	}else{
		    		return status
		    	}
		    },
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
</style>
