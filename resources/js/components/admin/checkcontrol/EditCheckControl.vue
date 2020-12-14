<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          Лоты
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/check-control">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <div class="accordion" id="accordionExample">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                <button
                  class="btn btn-link btn-block text-left"
                  type="button"
                  data-toggle="collapse"
                  data-target="#collapseOne"
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  Collapsible Group Item #1
                </button>
              </h2>
            </div>

            <div
              id="collapseOne"
              class="collapse show"
              aria-labelledby="headingOne"
              data-parent="#accordionExample"
            >
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life
                accusamus terry richardson ad squid. 3 wolf moon officia aute,
                non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua
                put a bird on it squid single-origin coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
                wes anderson cred nesciunt sapiente ea proident. Ad vegan
                excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim aesthetic synth nesciunt you probably
                haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">
                <button
                  class="btn btn-link btn-block text-left collapsed"
                  type="button"
                  data-toggle="collapse"
                  data-target="#collapseTwo"
                  aria-expanded="false"
                  aria-controls="collapseTwo"
                >
                  Collapsible Group Item #2
                </button>
              </h2>
            </div>
            <div
              id="collapseTwo"
              class="collapse"
              aria-labelledby="headingTwo"
              data-parent="#accordionExample"
            >
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life
                accusamus terry richardson ad squid. 3 wolf moon officia aute,
                non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua
                put a bird on it squid single-origin coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
                wes anderson cred nesciunt sapiente ea proident. Ad vegan
                excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim aesthetic synth nesciunt you probably
                haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingThree">
              <h2 class="mb-0">
                <button
                  class="btn btn-link btn-block text-left collapsed"
                  type="button"
                  data-toggle="collapse"
                  data-target="#collapseThree"
                  aria-expanded="false"
                  aria-controls="collapseThree"
                >
                  Collapsible Group Item #3
                </button>
              </h2>
            </div>
            <div
              id="collapseThree"
              class="collapse"
              aria-labelledby="headingThree"
              data-parent="#accordionExample"
            >
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life
                accusamus terry richardson ad squid. 3 wolf moon officia aute,
                non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua
                put a bird on it squid single-origin coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
                wes anderson cred nesciunt sapiente ea proident. Ad vegan
                excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim aesthetic synth nesciunt you probably
                haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    DatePicker,
    Multiselect,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters("checkcontrol", ["getAppCars"]),
  },
  async mounted() {
    await this.actionAppCars(this.$route.params.appId);
    console.log(this.getAppCars);
  },
  methods: {
    ...mapActions("checkcontrol", ["actionAppCars"]),
  },
};
</script>
<style scoped>
tr {
  cursor: pointer !important;
}
tr.active {
  background: #d6d6d6;
}
.check_box_with_label {
}
.check_box_with_label input {
  --active: #275efe;
  --active-inner: #fff;
  --focus: 2px rgba(39, 94, 254, 0.3);
  --border: #bbc1e1;
  --border-hover: #275efe;
  --background: #fff;
  --disabled: #f6f8ff;
  --disabled-inner: #e1e6f9;
  -webkit-appearance: none;
  -moz-appearance: none;
  height: 21px;
  outline: none;
  display: inline-block;
  vertical-align: top;
  position: relative;
  margin: 0;
  cursor: pointer;
  border: 1px solid var(--bc, var(--border));
  background: var(--b, var(--background));
  -webkit-transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  width: 38px;
  border-radius: 11px;
  min-height: unset;
}
.check_box_with_label input::after {
  content: "";
  display: block;
  position: absolute;
  -webkit-transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  left: 2px;
  top: 2px;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  background: var(--ab, var(--border));
  -webkit-transform: translateX(var(--x, 0));
  transform: translateX(var(--x, 0));
}
.check_box_with_label label {
  display: block;
  cursor: pointer;
  margin-bottom: 15px;
}
.check_box_with_label input[type="checkbox"]:checked {
  --ab: var(--active-inner);
  --x: 17px;
  --b: var(--active);
  --bc: var(--active);
  --d-o: 0.3s;
  --d-t: 0.6s;
  --d-t-e: cubic-bezier(0.2, 0.85, 0.32, 1.2);
}
input.disabled {
  cursor: not-allowed;
}
.cardtender {
  padding: 0;
  box-shadow: none;
  background-color: rgba(0, 0, 0, 0.03);
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}
.cardtender .card-header {
  background: #f3f3f4;
}
.without_padding {
  padding: 0px !important;
}
.without_padding ul {
  margin-bottom: 0px;
}
.without_padding li {
  text-align: center;
}
.list-inline li {
  border-bottom: 1px solid #000;
}
.list-inline li:last-child {
  border: none;
}
</style>
