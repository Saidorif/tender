<template>
  <div class="tender_page">
    <Header />
    <div class="container tender_block">
      <div class="col-md-12">
        <h2
          class="title"
          align="center"
          v-html="$t('conducted_tenders.title')"
        ></h2>
        <p class="sub_title">{{ $t("conducted_tenders.sub_title") }}</p>
        <div class="add_region">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="form-group col-xl-2 col-md-6">
                    <label for="name">{{ $t("Terderning sanasi") }}</label>
                    <div class="form-control input_style">
                      {{ form.time }}
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="address">{{ $t("Manzil") }}</label>
                    <div class="form-control input_style">
                      {{ form.address }}
                    </div>
                  </div>
                </div>
              </form>
              <div class="table-responsive">
                <div class="d-flex justify-content-center">
                  <h4>{{ $t("Lotlar") }}</h4>
                </div>
                <div
                  class="card cardtender"
                  v-for="(lot, index) of form.tenderlots"
                >
                  <div class="card-header">
                    <h4 class="lot_n"><em>{{ $t("Lot") }} №</em> {{ index + 1 }}</h4>
                    <button
                      type="button"
                      class="btn btn-info btn_save_category"
                      @click="sendRequset()"
                    >
                      <i class="far fa-share-square text-light"></i>
                      <span class="text-light">{{ $t("Soʼrovnoma yuborish") }}</span>
                    </button>
                  </div>
                  <div class="card-body" v-if="lot.direction_id.length">
                    <div class="mb-2" v-for="diritem of lot.direction_id">
                      <div
                        class="d-flex align-items-center justify-content-between"
                      >
                        <h4>1) {{ diritem.name }}</h4>
                        <router-link :to="'/u/demand-tab/'+diritem.id"  class="btn btn-outline-info"><i class="fas fa-eye"></i></router-link>
                      </div>
                      <div>
                        <h3 v-if="diritem.reysesFrom.length">
                          <span>
                            {{
                              diritem.reysesFrom[0].from
                                ? diritem.reysesFrom[0].from.name
                                : ""
                            }}
                            -
                            {{
                              diritem.reysesFrom[0].where
                                ? diritem.reysesFrom[0].where.name
                                : ""
                            }}
                            .</span>
                        </h3>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th scope="col" rowspan="5">{{ $t("Qatnovlar") }}</th>
                              <th scope="col" :colspan="diritem.reysesFrom[0].stations.length * 2" style="text-align:center;">
                                {{diritem.reysesFrom[0].from ? diritem.reysesFrom[0].from.name: ""}} {{ $t("tomondan") }}
                              </th>
                              <th scope="col" rowspan="3"> {{ $t("Reys ischinligi") }}</th>
                            </tr>
                            <tr><th colspan="2" v-for="stat of diritem.reysesTo[0].stations">{{stat.name}}</th></tr>
                            <tr >
                                <template v-for="stat of diritem.reysesTo[0].stations">
                                    <th>{{ $t("Kelish") }}</th>
                                    <th>{{ $t("Chiqish") }}</th>
                                </template>
                            </tr>
                          </thead>
                          <tbody>
                            <tr  v-for="(resto, ind) of diritem.reysesTo">
                              <td>{{ind+1}}</td>
                                <template v-for="r_time of resto.reys_times">
                                    <td>{{r_time.end}}</td>
                                    <td>{{r_time.start}}</td>
                                </template>
                              <td>{{ resto.reys_times[0].bus_order }}</td>
                            </tr>
                          </tbody>
                        </table>
                        <h3>
                          <span>
                            {{
                              diritem.reysesTo[0].from
                                ? diritem.reysesTo[0].from.name
                                : ""
                            }}
                            -
                            {{
                              diritem.reysesTo[0].where
                                ? diritem.reysesTo[0].where.name
                                : ""
                            }} </span>
                        </h3>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th scope="col" rowspan="5">{{ $t("Qatnovlar") }}</th>
                              <th scope="col" :colspan="diritem.reysesFrom[0].stations.length * 2" style="text-align:center;">
                                {{diritem.reysesTo[0].from ? diritem.reysesTo[0].from.name: ""}}{{ $t("tomondan") }}
                              </th>
                              <th scope="col" rowspan="3">{{ $t("Reys ischinligi") }}</th>
                            </tr>
                            <tr><th colspan="2" v-for="stat of diritem.reysesFrom[0].stations">{{stat.name}}</th></tr>
                            <tr >
                                <template v-for="stat of diritem.reysesFrom[0].stations">
                                    <th>{{ $t("Kelish") }}</th>
                                    <th>{{ $t("Chiqish") }}</th>
                                </template>
                            </tr>
                          </thead>
                          <tbody>
                            <tr  v-for="(resfrom, ind) of diritem.reysesFrom">
                              <td>{{ind+1}}</td>
                                <template v-for="r_time of resfrom.reys_times">
                                    <td>{{r_time.end}}</td>
                                    <td>{{r_time.start}}</td>
                                </template>
                              <td>{{ resfrom.reys_times[0].bus_order }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
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
import Header from "./Header";
import Loader from "../Loader";
export default {
  components: {
    Header,
    DatePicker,
    Multiselect,
    Loader,
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
    ...mapGetters("busbrand", ["getBusBrandList"]),
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
    // await this.actionEditTenderAnnounce(this.$route.params.tenderId);
    // this.form.time = this.getTenderAnnounce.time;
    // this.form.address = this.getTenderAnnounce.address;
    // this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
    // this.lots = this.getTenderAnnounce.tenderlots;
    // this.tenderlots = this.getTenderAnnounce.tenderlots;
    this.form = JSON.parse(localStorage.getItem("td"));
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
    activeEditClass(item) {
      if (item.status == "active") {
        return "edit-active";
      } else {
        return "edit-pending";
      }
    },
    getLengthReys(reys) {
      let count = 0;
      reys.reysesFrom.forEach((item, index) => {
        if (item.status == "pending") {
          count++;
        }
      });
      reys.reysesTo.forEach((item, index) => {
        if (item.status == "pending") {
          count++;
        }
      });
      return count;
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    sendRequset() {
      this.$router.push("/login");
    },
  },
};
</script>
<style scoped>
.lot_item {
  display: flex;
  width: 400px;
  justify-content: space-around;
  margin-bottom: 20px;
}
.lot_remove {
  cursor: pointer;
  font-size: 20px;
}
tr.active,
tr.inactive {
  cursor: pointer !important;
}
tr.active:hover,
tr.inactive:hover {
  background: #d0d0d0 !important;
}
tr.active,
tr.edit-pending {
  background: #d6d6d6;
}
tr.pending {
  background: #8e8e8e;
  cursor: not-allowed !important;
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
</style>
