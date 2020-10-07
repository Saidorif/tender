<template>
  <div class="about_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container about_block">
      <div class="col-md-12">
        <h2 class="title" align="center">
          Transport vazirligining <span>Tender onlayn</span> platformasi haqida
        </h2>
        <p class="sub_title">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos doloribus esse facere id adipisci quae recusandae, quibusdam officia vitae praesentium ipsum neque iusto sint, dolorum magnam natus vel illum architecto!
        </p>
        <p class="sub_title">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae dolore autem error, consequatur saepe a eius officia sed minus debitis ratione illum cum? Esse nostrum nihil totam natus. Natus et debitis at impedit fugiat labore consequuntur saepe quibusdam officiis tenetur, hic, ab ipsa adipisci quisquam porro atque! Odit nam, odio saepe adipisci cupiditate provident quod ipsam aperiam et totam alias voluptas ducimus impedit, amet eos. Earum maxime ipsum, sunt vitae veritatis minima ipsa cumque consequatur, eos harum molestias mollitia iure voluptates, voluptatibus at architecto unde temporibus magnam animi ullam. Consequuntur sapiente nisi velit eligendi, tempora beatae et facere laborum eaque!
        </p>
        <p class="sub_title">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae dolore autem error, consequatur saepe a eius officia sed minus debitis ratione illum cum? Esse nostrum nihil totam natus. Natus et debitis at impedit fugiat labore consequuntur saepe quibusdam officiis tenetur, hic, ab ipsa adipisci quisquam porro atque! Odit nam, odio saepe adipisci cupiditate provident quod ipsam aperiam et totam alias voluptas ducimus impedit, amet eos. Earum maxime ipsum, sunt vitae veritatis minima ipsa cumque consequatur, eos harum molestias mollitia iure voluptates, voluptatibus at architecto unde temporibus magnam animi ullam. Consequuntur sapiente nisi velit eligendi, tempora beatae et facere laborum eaque!
        </p>
        <p class="sub_title">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae dolore autem error, consequatur saepe a eius officia sed minus debitis ratione illum cum? Esse nostrum nihil totam natus. Natus et debitis at impedit fugiat labore consequuntur saepe quibusdam officiis tenetur, hic, ab ipsa adipisci quisquam porro atque! Odit nam, odio saepe adipisci cupiditate provident quod ipsam aperiam et totam alias voluptas ducimus impedit, amet eos. Earum maxime ipsum, sunt vitae veritatis minima ipsa cumque consequatur, eos harum molestias mollitia iure voluptates, voluptatibus at architecto unde temporibus magnam animi ullam. Consequuntur sapiente nisi velit eligendi, tempora beatae et facere laborum eaque!
        </p>
        <p class="sub_title">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae dolore autem error, consequatur saepe a eius officia sed minus debitis ratione illum cum? Esse nostrum nihil totam natus. Natus et debitis at impedit fugiat labore consequuntur saepe quibusdam officiis tenetur, hic, ab ipsa adipisci quisquam porro atque! Odit nam, odio saepe adipisci cupiditate provident quod ipsam aperiam et totam alias voluptas ducimus impedit, amet eos. Earum maxime ipsum, sunt vitae veritatis minima ipsa cumque consequatur, eos harum molestias mollitia iure voluptates, voluptatibus at architecto unde temporibus magnam animi ullam. Consequuntur sapiente nisi velit eligendi, tempora beatae et facere laborum eaque!
        </p>
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