<template>
  <div class="oldprotocol">
    <Loader v-if="laoding" />
    <div class="card">
      <div class="card-header header_filter">
        <div class="header_title mb-2">
          <h4 class="title_user">
            <i class="peIcon pe-7s-box1"></i>
            Старые протоколы
          </h4>
          <div class="add_user_btn">
            <button
              type="button"
              class="btn btn-info toggleFilter"
              @click.prevent="toggleFilter"
            >
              <i class="fas fa-filter"></i>
              Филтр
            </button>
            <router-link
              class="btn btn-primary"
              to="/crm/oldprotocol/add"
              v-if="$can('store', 'ProtocolController')"
            >
              <i class="fas fa-plus"></i>
              Добавить
            </router-link>
          </div>
        </div>

        <transition name="slide">
          <div class="filters" v-if="filterShow">
            <div class="row">
              <div class="form-group col-lg-2">
                <label for="bypass_number">Номер</label>
                <input
                  class="form-control input_style"
                  placeholder="Поиск по номеру"
                  type="text"
                  v-model="filter.number"
                  id="bypass_number"
                />
              </div>
              <div class="form-group col-lg-2">
                <label for="region_id">Сортировать по региону!</label>
                <select
                  id="region_id"
                  class="form-control input_style"
                  v-model="filter.region_id"
                >
                  <option value="" selected>Выберите регион!</option>
                  <option
                    :value="item.id"
                    v-for="(item, index) in getRegionList"
                  >
                    {{ item.name }}
                  </option>
                </select>
              </div>
              <div class="form-group col-lg-3">
                <label for="year">Сортировать по дате</label>
                <date-picker
                  lang="ru"
                  type="year"
                  format="YYYY"
                  valueType="format"
                  v-model="filter.year"
                  placeholder="Выберите дату!"
                  class="input_style"
                ></date-picker>
              </div>
              <div class="col-lg-12 form-group d-flex justify-content-end">
                <button
                  type="button"
                  class="btn btn-warning clear"
                  @click.prevent="clear"
                >
                  <i class="fas fa-times"></i>
                  сброс
                </button>
                <button
                  type="button"
                  class="btn btn-primary ml-2"
                  @click.prevent="search"
                >
                  <i class="fas fa-search"></i>
                  найти
                </button>
              </div>
            </div>
          </div>
        </transition>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table
            class="table table-bordered text-center table-hover table-striped"
          >
            <thead>
              <tr>
                <th scope="col">№</th>
                <th scope="col">Регион</th>
                <th scope="col">Номер протокола</th>
                <th scope="col">Сана</th>
                <th scope="col">Действия</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in getOldprotocols.data">
                <td scope="row">{{ index + 1 }}</td>
                <td>{{ item.region ? item.region.name : "" }}</td>
                <td>{{ item.number }}</td>
                <td>{{ item.date }}</td>
                <td>
                  <router-link
                    tag="button"
                    class="btn_transparent"
                    :to="`/crm/oldprotocol/edit/${item.id}`"
                    v-if="$can('edit', 'ProtocolController')"
                  >
                    <i class="pe_icon pe-7s-edit editColor"></i>
                  </router-link>
                  <button
                    class="btn_transparent"
                    @click="deleteOldprotocol(item.id)"
                    v-if="$can('destroy', 'ProtocolController')"
                  >
                    <i class="pe_icon pe-7s-trash trashColor"></i>
                  </button>
                </td>
              </tr>
            </tbody>
            <pagination
              :limit="4"
              :data="getOldprotocols"
              @pagination-change-page="getResults"
            ></pagination>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DatePicker from "vue2-datepicker";
import Loader from "../../Loader";
export default {
  components: {
    Loader,
    DatePicker,
  },
  data() {
    return {
      filter: {
        region_id: "",
        year: "",
        number: "",
      },
      laoding: true,
      filterShow: false,
    };
  },
  async mounted() {
    let page = 1;
    await this.actionOldprotocols(page);
    await this.actionRegionList();
    this.laoding = false;
  },
  computed: {
    ...mapGetters("oldprotocol", ["getOldprotocols", "getMassage"]),
    ...mapGetters("region", ["getRegionList"]),
  },
  methods: {
    ...mapActions("oldprotocol", [
      "actionOldprotocols",
      "actionDeleteOldprotocol",
    ]),
    ...mapActions("region", ["actionRegionList"]),
    async search(){
		let page = 1
		if( this.filter.region_id != '' || this.filter.year != '' || this.filter.number != ''){
			let data = {
				page:page,
				items:this.filter
            }
			await this.actionOldprotocols(data)
		}
	},
	async clear(){
			this.filter.region_id = ''
			this.filter.year = ''
			this.filter.number = ''
            let page  = 1
            await this.actionDirections({page: page,items:this.filter})
	},
    toggleFilter() {
      this.filterShow = !this.filterShow;
    },
    async getResults(page = 1) {
      this.laoding = true;
      await this.actionOldprotocols(page);
      this.laoding = false;
    },
    async deleteOldprotocol(id) {
      if (confirm("Вы действительно хотите удалить?")) {
        let page = 1;
        this.laoding = true;
        await this.actionDeleteOldprotocol(id);
        await this.actionOldprotocols(page);
        this.laoding = false;
        toast.fire({
          type: "success",
          icon: "success",
          title: "Oldprotocol удалено!",
        });
      }
    },
  },
};
</script>
<style scoped>
.toggleFilter {
  margin-right: 15px;
}
</style>
