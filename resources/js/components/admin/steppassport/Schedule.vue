<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <h2>{{titulData.type.type}} - {{titulData.pass_number}} - sonli "{{titulData.name}}"Avtobus yo'nalishi qatnov yo'li masofasini va xarakat vaqtini olchash qaydnomasi</h2>
    <div class="col-md-4">
      <p>
        Qatnov yo'l masofasi
        <b>{{titulData.timing_with[titulData.timing_with.length - 1].end_speedometer}} km</b>
      </p>
    </div>
    <div class="col-md-4">
      <p>Qatnovchi avtomobillar soni</p>
    </div>
    <div class="col-md-4">
      <p>Yolkira xaqqi so'm</p>
    </div>
    <div class="table-responisve">
      <table class="table table-bordered text-center table-hover table-striped">
        <thead>
          <tr>
            <th scope="col" colspan="8">Toshkent tomonga</th>
            <th scope="col" rowspan="3">Toxtash joylarining nomlari</th>
            <th scope="col" colspan="8">Nukus tomonga</th>
          </tr>
          <tr>
            <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
            <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
          </tr>
          <tr>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(table,index) in titulData.timing_with">
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1">{{table.region_from.name}}</th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
            <th  colspan="1"></th>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["titulData"],
  components: {
    DatePicker,
  },
  data() {
    return {
      form: {},
    };
  },
  async mounted() {
    this.form = this.titulData.timing_with
    console.log(this.form)
  },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
  },
  methods: {
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable"]),
    async saveData() {},
    isRequired(input) {
      return this.requiredInput && input === "";
    },
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
</style>