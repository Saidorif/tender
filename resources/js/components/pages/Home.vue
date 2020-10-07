<template>
    <div class="home_page">
        <Loader v-if="laoding"/>
        <Header/>
        <div class="header_banner">
            <div class="container">
                <div class="left_item">
                    <h1>Transport vazirligi <span>tender</span>  platformasi</h1>
                    <p>Endi siz uyingizda o'tirgan holda tenderda  qatnashish <br> imkonyatiga  ega bo'ldingiz.</p>
                        <a href="#" class="mr-3" ><img src="/img/google-play.svg" alt=""></a>
                        <a href="#" ><img src="/img/app-store.svg" alt=""></a>
                </div>
                <div class="right_item"><img src="/img/b-laptop.png" alt=""></div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Header from './Header'
import Loader from '../Loader'
export default {
    components:{
        Header,
        Loader
    },
  data() {
    return {
        laoding: true
    };
  },
  computed: {},
  mounted() {
    this.laoding = false
  },
  methods: {},
};
</script>
<style  scoped>

</style>


<Loader v-if="laoding"/>
import Loader from '../../Loader'
components:{
    Loader
},
laoding: true
this.laoding = false