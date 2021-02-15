<template>
  <div class="tender_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">Bu bo'limda siz  bo'lib o'tgan tenderlar royxati bilan tanishasiz</p>
        <div class="tenders_list">
            <!-- tender_card -->
            <div class="tender_card" v-for="item of getTenderIndexCompleted.data"  v-if="getTenderIndexCompleted.data.length">
                <div class="tender_card_header">
                    <h6>Yo'nalish nomi</h6>
                    <h5>{{item.direction_ids[0].name}}</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Yo'nalish masofasi (km)</h6>
                        <p>	{{item.direction_ids[0].distance}}</p>
                    </div>
                    <div class="card_item">
                        <h6>Korxona nomi</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>Sana</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>Holati</h6>
                        <p>Tugatilgan</p>
                    </div>
                </div>
                <router-link :to="'/u/demand-tab/'+item.id" class="tender_card_footer" >Batafsil</router-link>
            </div>
            <div class="d-flex justify-content-center w-100 pt-5 pb-5" v-if="getTenderIndexCompleted.data && !getTenderIndexCompleted.data.length">
                <p class="alert alert-info" >Faol tenderlar mavjud emas</p>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import Header from './Header'
import Loader from '../Loader'
export default {
    components:{
        Header,
        Loader
    },
  data() {
    return {laoding: true};
  },
  computed: {
    ...mapGetters('page',['getTenderIndex', 'getTenderIndexCompleted'])
  },
  async mounted() {
    let page = 1;
    await this.actionTenderIndex(page);
    await this.actionTenderIndexCompleted(page);
    console.log(this.getTenderIndexCompleted)
    this.laoding = false
  },
  methods: {
    ...mapActions('page',['actionTenderIndex', 'actionTenderIndexCompleted']),
  },
};
</script>
<style scoped>
.tender_card_header .time_counter{
    background: transparent !important;
}
.time_counter{
    background: transparent !important;
}
.block_title{
    font-size: 30px;
    font-weight: bold;
    padding-top: 20px;
    margin: 0px;
    position: relative;
}
.block_title::before{
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 60px;
    height: 3px;
    background: #292666;
}
.tenders_list{
    margin-bottom: 30px;
}
</style>
