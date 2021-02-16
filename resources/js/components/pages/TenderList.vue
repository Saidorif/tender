<template>
  <div class="tender_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">Bu bo'limda siz bo'lib o'tadigan tenderlar royxati bilan tanishasiz</p>
        <div class="tenders_list">
            <!-- tender_card -->
            <div class="tender_card" v-for="item of getTenderIndex.data" v-if="getTenderIndex.data.length">
                <div class="tender_card_header">
                    <h6>{{item.direction_ids[0].name}}</h6>
                    <h5 :id="'myID'+item.id">{{$g.dateCounter(item.time, 'myID'+item.id)}}</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Address</h6>
                        <p>{{item.address}}</p>
                    </div>
                    <div class="card_item">
                        <h6>Tender tugash vaqti</h6>
                        <p>{{item.time}}	</p>
                    </div>
                    <div class="card_item">
                        <h6>Lotlar soni</h6>
                        <p>{{item.tenderlots.length}}</p>
                    </div>
                    <div class="card_item">
                        <h6>Yo'nalish turi</h6>
                        <p>{{item.direction_ids[0].dir_type == 'bus' ? "Avtobus yo'nalishi" : "Taxi yo'nalishi"}}</p>
                    </div>
                </div>
                <!-- <router-link  :to="'/u/show-tender-details/'+item.id" class="tender_card_footer" >Batafsil</router-link> -->
                <a  role="button" class="tender_card_footer" @click.prevent="showTenderDetails(item)" >Batafsil</a>
            </div>
            <div class="d-flex justify-content-center w-100 pt-5 pb-5" v-if="getTenderIndex.data && !getTenderIndex.data.length">
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
    this.laoding = false
  },
  methods: {
    ...mapActions('page',['actionTenderIndex', 'actionTenderIndexCompleted']),
    showTenderDetails(item){
        localStorage.setItem('td', JSON.stringify(item));
        this.$router.push('/u/show-tender-details/'+item.id)
    }
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
.tender_card_footer{
    cursor: pointer;
    color: white !important;
}
</style>
