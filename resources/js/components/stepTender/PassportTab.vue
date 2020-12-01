<template>
  <div class="passport_tab">
    <Loader v-if="laoding"/>
    <Header />
    <div class="container tender_block">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item">
          <router-link :to='`/u/titul-tab/${$route.params.directionId}`' >Titul</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/timing-tab/${$route.params.directionId}`'>Xronametraj</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/scheme-tab/${$route.params.directionId}`'>Sxema</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/schedule-tab/${$route.params.directionId}`'>Xarkatlanish jadvali</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/tarif-tab/${$route.params.directionId}`'>Tarif</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/demand-tab/${$route.params.directionId}`'>Talab</router-link>
        </li>
      </ul>
    </div>
    <!-- <router-link class="btn btn-primary back_btn" to="/crm/direction">
      <span class="peIcon pe-7s-back"></span> 
      Назад
    </router-link> -->
  </div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
  import Header from '../pages/Header'
  import Loader from '../Loader'
	export default{
        components: {
          Header,
          Loader,
        },
		data(){
			return{
        laoding:false
			}
		},
		data() {
      return {laoding: true};
    },
    computed: {},
    async mounted() {
      this.laoding = false
    },
		methods:{}
	}
</script>
<style scoped>

</style>