<template>
  	<form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">

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
					console.log(this.titulData)
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