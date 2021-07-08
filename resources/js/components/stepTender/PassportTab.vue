<template>
  <div class="passport_tab">
    <Loader v-if="laoding"/>
    <Header />
    <div class="container tender_block">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item">
          <router-link :to='`/u/titul-tab/${$route.params.directionId}`' >{{$t('Titul')}}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/timing-tab/${$route.params.directionId}`'>{{$t('Xronametraj')}}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/scheme-tab/${$route.params.directionId}`'>{{$t('Sxema')}}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/schedule-tab/${$route.params.directionId}`'>{{$t('Xarkatlanish jadvali')}}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/tarif-tab/${$route.params.directionId}`'>{{$t('Tarif')}}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to='`/u/demand-tab/${$route.params.directionId}`'>{{$t('Talab')}}</router-link>
        </li>
      </ul>
    </div>

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
    .nav.nav-tabs{
        padding-top: 40px;
        justify-content: center;
    }
    .nav-item a.active{
        border: 2px solid;
        color: #292666;
    }
    .nav-item a{
         display: flex;
        align-items: center;
        font-weight: bold;
        padding: 6px 30px;
        border-radius: 30px;
        font-family: "Poppins-Medium";
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        color: #9CA1AB;
        text-decoration: none !important;
    }

</style>
