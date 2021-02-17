<template>
  <div class="about_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container about_block">
      <div class="col-md-12">
        <h2  align="center" class="title"><span>Yo'nalish</span> tarifni bilish </h2>

      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { TokenService } from "./../../services/storage.service";
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
  async mounted() {
    this.laoding = false
  },
  methods: {},
};
</script>
<style scoped>
</style>
