<template>
  <div class="tender_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">{{$t('conducted_tenders.sub_title')}}</p>
        <div class="tenders_list">
            <!-- tender_card -->
            <div class="tender_card" v-for="item of getTenderIndexCompleted.data"  v-if="getTenderIndexCompleted.data.length">
                <div class="tender_card_header">
                    <h6>{{$t('Yoʼnalish nomi')}}</h6>
                    <h5>{{item.direction_ids[0].name}}</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>{{$t('Yoʼnalish masofasi')}} ({{$t('km')}})</h6>
                        <p>	{{item.direction_ids[0].distance}}</p>
                    </div>
                    <div class="card_item">
                        <h6>{{$t('Korxona nomi')}}</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>{{$t('Sana')}}</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>{{$t('Holati')}}</h6>
                        <p>Tugatilgan</p>
                    </div>
                </div>
                <a href="#" @click.prevent="showTenderDetails(item)" class="tender_card_footer" >{{$t('Batafsil')}}</a>
            </div>
            <div class="d-flex justify-content-center w-100 pt-5 pb-5" v-if="getTenderIndexCompleted.data && !getTenderIndexCompleted.data.length">
                <p class="alert alert-info" >{{$t('Faol tenderlar mavjud emas')}}</p>
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
</style>
