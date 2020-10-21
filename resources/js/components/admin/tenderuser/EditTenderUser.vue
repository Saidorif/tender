<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-bullhorn"></i>
          Посмотреть тендер
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="form-group col-md-2">
              <label for="name">Дата тердера</label>
              <div class="form-control input_style">
                {{ form.time }}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="address">Адрес</label>
              <div class="form-control input_style">
                {{ form.address }}
              </div>
            </div>
          </div>
        </form>
        <div class="table-responsive" v-if="tenderlots.length > 0">
          <div class="d-flex justify-content-center">
            <h4>Лоты</h4>
          </div>
          <div class="choosenItemsTable" v-for="(t_lots,t_index) in tenderlots">
            <div class="d-flex">
              <h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
              <button
                type="button"
                class="btn btn-info btn_save_category"
                @click.prevent="getEditId(t_lots.id)"
              >
                <i class="far fa-share-square text-light"></i>
                <span class="text-light">Отправить заявку</span>
              </button>
            </div>
            <ul v-for="(items,index) in t_lots.direction_id">
                <template>
                  <li class="mb-2" v-if="getLengthReys(lots[index],items.reysesFrom) > 0">

                  <!-- <li class="mb-2"> -->
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'from'" aria-expanded="false" :aria-controls="'collapseExample'+index+'from'">
                        <template>
                        <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span> 
                        <span>({{getLengthReys(lots[index],items.reysesFrom)}} рейсы)</span>
                        </template>
                    </button>
                    <router-link 
                      :to='`/crm/direction/demand-tab/${items.id}`' 
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  <div class="collapse" :id="'collapseExample'+index+'from'" v-if="items.reysesFrom.length > 0">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>№</th>
                          <th v-for="(item,index) in items.reysesFrom[0].reys_times" colspan="2">
                            {{item.where.name}}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr 
                          v-for="(reys,key) in items.reysesFrom"
                          :class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
                        >
                          <td>{{key+1}}</td>
                          <template v-for="(val,key) in reys.reys_times">
                            <td>{{val.start}}</td>
                            <td>{{val.end}}</td>
                          </template>
                        </tr>
                      </tbody>
                    </table>
                </div>
                </li>
                  <li v-if="getLengthReys(lots[index],items.reysesTo) > 0">
                  <!-- <li> -->
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'to'" aria-expanded="false" :aria-controls="'collapseExample'+index+'to'">
                        <template>
                        <span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span> 
                        <span>({{getLengthReys(lots[index],items.reysesTo)}} рейсы)</span>
                        </template>
                    </button>
                    <router-link 
                      :to='`/crm/direction/demand-tab/${items.id}`' 
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  <div class="collapse" :id="'collapseExample'+index+'to'" v-if="items.reysesTo.length > 0">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>№</th>
                          <th v-for="(item,index) in items.reysesTo[0].reys_times" colspan="2">
                            {{item.where.name}}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr 
                          v-for="(reys,key) in items.reysesTo"
                          :class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
                        >
                          <td>{{key+1}}</td>
                          <template v-for="(val,key) in reys.reys_times">
                            <td>{{val.start}}</td>
                            <td>{{val.end}}</td>
                          </template>
                        </tr>
                      </tbody>
                    </table>
                </div>
                </li>
                </template>
                <!-- <template v-if="lots[index].reys_id == 0"> -->
                <template>
                  <li>
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
                        <template>
                          <span>{{items.name}}</span>
                        </template>
                    </button>
                    <router-link 
                      :to='`/crm/direction/demand-tab/${items.id}`' 
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  </li>
                </template>
            </ul>
          </div>
        </div>

        <!-- <div class="table-responsive" v-if="edit_direction_ids.length > 0">
          <div class="choosenItemsTable">
            <ul v-for="(items, index) in edit_direction_ids">
              <template>
                <li
                  class="mb-2"
                  v-if="getLengthReys(lots[index], items.reysesFrom) > 0"
                >
                  <h4>
                    <span
                      >{{ items.reysesFrom[0].where.name }} -
                      {{ items.reysesFrom[0].from.name }}</span
                    >
                      <router-link
                        :to="`/crm/stepuser/demand-tab/${items.id}`"
                        class="btn btn-outline-info"
                      >
                        <i class="fas fa-eye"></i>
                      </router-link>
                  </h4>
                  <b
                    >({{
                      getLengthReys(lots[index], items.reysesFrom)
                    }}
                    рейсы)</b
                  >
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>№</th>
                        <th
                          v-for="(item, index) in items.reysesFrom[0]
                            .reys_times"
                          colspan="2"
                        >
                          {{ item.where.name }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(reys, key) in items.reysesFrom"
                        :class="
                          activeEditClass(lots[index], reys.id) ? 'active' : ''
                        "
                      >
                        <td>{{ key + 1 }}</td>
                        <template v-for="(val, key) in reys.reys_times">
                          <td>{{ val.start }}</td>
                          <td>{{ val.end }}</td>
                        </template>
                      </tr>
                    </tbody>
                  </table>
                </li>
                <li v-if="getLengthReys(lots[index], items.reysesTo) > 0">
                  <h4>
                    <span
                      >{{ items.reysesTo[0].where.name }} -
                      {{ items.reysesTo[0].from.name }}</span
                    >
                     <router-link
                        :to="`/crm/stepuser/demand-tab/${items.id}`"
                        class="btn btn-outline-info"
                      >
                        <i class="fas fa-eye"></i>
                      </router-link>
                  </h4>
                  <b
                    >({{ getLengthReys(lots[index], items.reysesTo) }} рейсы)</b
                  >
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>№</th>
                        <th
                          v-for="(item, index) in items.reysesTo[0].reys_times"
                          colspan="2"
                        >
                          {{ item.where.name }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(reys, key) in items.reysesTo"
                        :class="
                          activeEditClass(lots[index], reys.id) ? 'active' : ''
                        "
                      >
                        <td>{{ key + 1 }}</td>
                        <template v-for="(val, key) in reys.reys_times">
                          <td>{{ val.start }}</td>
                          <td>{{ val.end }}</td>
                        </template>
                      </tr>
                    </tbody>
                  </table>
                </li>
              </template>
              <template v-if="lots[index].reys_id == 0">
                <li>
                  <div class="d-flex align-items-center">
                    <button
                      class="btn btn-outline-secondary mr-3 ml-3"
                      type="button"
                      data-toggle="collapse"
                      :data-target="'#collapseExample' + index"
                      aria-expanded="false"
                      :aria-controls="'collapseExample' + index"
                    >
                      <template>
                        <span>{{ items.name }}</span>
                      </template>
                    </button>
                    <router-link 
                        :to='`/crm/stepuser/demand-tab/${items.id}`' 
                        class="btn btn-outline-info mr-2"
                      >
                        <i class="fas fa-eye"></i>
                    </router-link>
                  </div>
                </li>
              </template>
            </ul>
          </div>
        </div> -->
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
    return {
      form: {
        direction_ids: [],
        time: "",
        address: "",
        type: "simple",
      },
      requiredInput: false,
      direction_ids: {},
      isLoading: false,
      edit_direction_ids: [],
      lots: [],
      tenderlots: [],
    };
  },
  computed: {
    ...mapGetters("application", [
      "getApplications",
      "getApplication",
      "getMassage",
      "getUserEditApplication",
      "getUserApplications",
      "getAddMessage",
    ]),
    ...mapGetters("tenderannounce", ["getMassage", "getTenderAnnounce"]),
    ...mapGetters("direction", ["getDirectionFindList"]),
    ...mapGetters("passportTab", ["getSchedule"]),
  },
  watch: {
    getTenderAnnounce: {
      handler() {
        this.form.time = this.getTenderAnnounce.time;
        this.form.address = this.getTenderAnnounce.address;
        this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
        this.lots = this.getTenderAnnounce.tenderlots;
        this.tenderlots = this.getTenderAnnounce.tenderlots;
      },
    },
  },
  async mounted() {
    await this.actionEditTenderAnnounce(this.$route.params.tenderuserId);
    this.form.time = this.getTenderAnnounce.time;
    this.form.address = this.getTenderAnnounce.address;
    this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
    this.lots = this.getTenderAnnounce.tenderlots;
    this.tenderlots= this.getTenderAnnounce.tenderlots
  },
  methods: {
    ...mapActions("application", [
      "actionApplications",
      "actionDeleteApplication",
      "actionAddApplication",
      "actionUserEditApplication",
      "actionApplicationList",
    ]),
    ...mapActions("tenderannounce", [
      "actionAddTenderAnnounce",
      "actionEditTenderAnnounce",
      "actionUpdateTenderAnnounce",
      "actionDeleteTenderAnnounceItem",
    ]),
    ...mapActions("direction", ["actionDirectionFind"]),
    ...mapActions("passportTab", ["actionGetScheduleTable"]),
    ...mapActions("busbrand", ["actionBusBrandList"]),
    async getEditId(id) {
      let data = {
        tender_id: this.$route.params.tenderuserId,
        lot_id: id,
      };
      await this.actionUserEditApplication(data);
      if (this.getUserEditApplication.success) {
        this.$router.push(
          "/crm/application/user/" + this.getUserEditApplication.result.id
        );
      }
    },
    activeEditClass(lots,id){
      let lot_list = lots.reys_id
      if (lot_list.length > 0) {
        if (lot_list.includes(id)) {
          return true
        }
      }
    },
    getLengthReys(lots,reys){
      if (lots) {
        let lot_list = lots.reys_id
        let count = 0;
        reys.forEach((item,index)=>{
          if (lot_list.includes(item.id)) {
            count++
          }
        })
        return count
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
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
</style>
