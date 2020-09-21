<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <h2>Schedule</h2>
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
      form:{ },
    };
  },
  async mounted() {
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