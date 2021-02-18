<template>
  <div class="about_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container about_block">
      <div class="col-md-12">
        <h2  align="center" class="title"><span>Yo'nalish</span> tarifni bilish </h2>
        <div  class="input-group input_group_with_label">
            <input  type="text" id="number" class="form-control" v-model="form.number">
            <label  for="number">Marshurut raqami</label>
            <button  @click="checkAuto()" class="btn_login ml-2"><i class="fas fa-search"></i> Qidirish</button>
        </div>
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
      laoding: true,
      form:{
        number: '',
      }
    };
  },
  computed: {
    ...mapGetters("page", ["getMassage", "getGetTarifByNumber"])
  },
  async mounted() {

    this.laoding = false
  },
  methods: {
    ...mapActions("page", ["actionGetTarifByNumber"]),
    async checkAuto(){
        if(this.form.number != ''){
            await this.actionGetTarifByNumber(this.form);
        }
    }
  },
};
</script>
<style scoped>
</style>
