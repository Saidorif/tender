<template>
  <div class="add_area">
    <Loader v-if="laoding" />
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab />
      </div>
      <div class="card-body">
        <div class="col-12 d-flex justify-content-end align-items-start mb-2">
          <span
            class="alert alert-success mr-2"
            v-if="getDirection.xronom_status == 'completed'"
            style="padding: 6px 20px"
            >{{$t('Tasdiqlangan')}}</span
          >
          <span
            class="alert alert-warning mr-2"
            v-if="getDirection.xronom_status == 'pending'"
            style="padding: 6px 20px"
            >{{$t('Kutish jarayonida')}}</span
          >
          <span
            class="alert alert-danger mr-2"
            v-if="getDirection.xronom_status == 'active'"
            style="padding: 6px 20px"
            >{{$t('Tasdiqlanmagan')}}</span
          >
          <button
            type="button"
            class="btn btn-warning"
            @click="$g.printDoc('prindDiv')"
          >
            <i class="fas fa-print mr-2"></i>{{$t('Chop etish')}}
          </button>
        </div>
        <form
          @submit.prevent.enter="saveData"
          enctype="multipart/form-data"
          class="row tabRow"
        >
          <h2>{{ getDirection.name }} {{$t('boʼyicha boshlangʼich maʼlumot')}} </h2>
          <div class="col-xl-12 tabs_block">
            <div class="form-group col-xl-3 col-md-6">
              <label for="timingDetails_date">{{$t('Oʼchov oʼtkazilgan kun')}}</label>
              <date-picker
                lang="ru"
                class="input_style"
                v-model="timingDetails.date"
                type="date"
                format="DD-MM-YYYY"
                valueType="format"
                :class="isRequired(timingDetails.date) ? 'isRequired' : ''"
              ></date-picker>
            </div>
            <div class="form-group col-xl-3 col-md-6">
              <label for="avto_model">{{$t('Xronametraj oʼtqizilgan avtomabil rusumi')}}</label
              >
              <input
                type="text"
                v-model="timingDetails.avto_model"
                id="avto_model"
                class="form-control input_style"
                :class="
                  isRequired(timingDetails.avto_model) ? 'isRequired' : ''
                "
              />
            </div>
            <div class="form-group col-xl-3 col-md-6">
              <label for="avto_number">{{$t('Xronametraj oʼtqizilgan avtomabil davlat raqami')}}</label>
              <input
                type="text"
                v-model="timingDetails.avto_number"
                id="avto_number"
                class="form-control input_style"
                :class="
                  isRequired(timingDetails.avto_number) ? 'isRequired' : ''
                "
              />
            </div>
            <h4 class="col-xl-12">{{$t('Xronametraj oʼtkazgan shaxslar')}}</h4>
            <template v-for="(person, p_index) in timingDetails.persons">
              <div class="form-group col-xl-2">
                <label for="person_name">{{$t('Ism')}}</label>
                <input
                  type="text"
                  v-model="person.name"
                  class="form-control input_style"
                  :class="isRequired(person.name) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-xl-2">
                <label for="surname">{{$t('Familiya')}}</label>
                <input
                  type="text"
                  v-model="person.surname"
                  class="form-control input_style"
                  :class="isRequired(person.surname) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-xl-3 col-md-6">
                <label for="person_job">{{$t('Ish joyi')}}</label>
                <input
                  type="text"
                  v-model="person.job"
                  id="person_job"
                  class="form-control input_style"
                  :class="isRequired(person.job) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-xl-3 col-md-6">
                <label for="person_position">{{$t('Lavozimi')}}</label>
                <input
                  type="text"
                  v-model="person.position"
                  id="person_position"
                  class="form-control input_style"
                  :class="isRequired(person.position) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-xl-1">
                <button
                  @click="addPerson()"
                  type="button"
                  class="btn btn-info mr-2"
                  v-if="timingDetails.persons.length == p_index + 1"
                >
                  <i class="fas fa-plus"></i>
                </button>
                <button
                  @click="removePerson(p_index)"
                  type="button"
                  class="btn btn-danger"
                  v-if="p_index > 2"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </template>
          </div>
          <h2>{{$t('Asosiy maʼlumotlar')}}</h2>
          <div class="col-xl-12 tabs_block">
            <div class="form-group col-xl-6">
              <label for="start_speedometer">{{$t('Boshlangʼich manzil nomi')}} </label>
              <input
                type="text"
                v-model="form.whereForm.name"
                id="start_speedometer"
                class="form-control input_style"
                disabled
              />
            </div>
            <div class="form-group col-xl-6">
              <label for="start_speedometer"
                >{{$t('Jonash vaqtida (km) Boshlangʼich spidometr koʼrsatkichi')}}
              </label>
              <input
                type="number"
                v-model="form.start_speedometer"
                id="start_speedometer"
                class="form-control input_style"
                :class="
                  isRequiredTwo(form.start_speedometer) ? 'isRequired' : ''
                "
                step="0.01"
                :disabled="tableTwoData.length > 0"
              />
            </div>
            <div class="form-group col-xl-6">
              <label for="start_time">{{$t('Boshlash vaqti')}}</label>
              <date-picker
                lang="ru"
                class="input_style"
                v-model="form.start_time"
                :type="getDirection.type_id == 5 ? 'datetime' : 'time'"
                :class="isRequiredTwo(form.start_time) ? 'isRequired' : ''"
                format="HH:mm:ss"
              ></date-picker>
            </div>
            <div class="form-group col-xl-6">
              <label for="speed_between_station"
                >{{$t('Bekatlar oraligʼidagi xarakat')}} ({{$t('km/soat')}})</label
              >
              <input
                type="number"
                v-model="form.speed_between_station"
                id="speed_between_station"
                class="form-control input_style"
                :class="
                  isRequiredTwo(form.speed_between_station) ? 'isRequired' : ''
                "
                step="0.01"
              />
            </div>
            <div class="form-group col-xl-6">
              <label for="speed_between_limited_space"
                >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}} ({{$t('km/soat')}})</label
              >
              <input
                type="number"
                v-model="form.speed_between_limited_space"
                id="speed_between_limited_space"
                class="form-control input_style"
                :class="
                  isRequiredTwo(form.speed_between_limited_space)
                    ? 'isRequired'
                    : ''
                "
                step="0.01"
              />
            </div>
            <div
              class="form-group col-xl-6 triple_input"
              v-for="(detail, p_index) in form.details"
            >
              <label>{{$t('Qatnov yoʼli xaqidagi maʼlumotlar')}}</label>
              <select
                class="form-control input_style"
                v-model="detail.sign"
                @change="signSelect(detail)"
              >
                <option
                  v-for="(s_item, s_index) in form.detailsOptions"
                  :value="s_item"
                  :key="s_index"
                >
                  {{ s_item.name }}
                </option>
              </select>
              <input
                type="text"
                v-model="detail.count"
                class="form-control input_style"
              />
              <button
                @click="addDetail()"
                class="btn btn-info"
                v-if="form.details.length == p_index + 1"
                type="button"
              >
                <i class="fas fa-plus"></i>
              </button>
              <button
                @click="removeDetail(p_index)"
                class="btn btn-danger"
                v-if="form.details.length > p_index + 1"
                type="button"
              >
                <i class="fas fa-trash"></i>
              </button>
            </div>
            <div class="form-group col-xl-6">
              <label
                for="whereToregion_to_id"
                :class="isRequiredTwo(form.whereTo) ? 'isRequired' : ''"
                >{{$t('Oraliq toʼxtash viloyat nomi')}}</label
              >
              <input
                v-model="form.whereTo"
                type="radio"
                name="where_to"
                :value="form.region_to_id"
                id="whereToregion_to_id"
              />
              <select
                class="form-control input_style"
                v-model="form.region_to_id"
                @change="selectRegion('region_to_id')"
                :class="isRequiredTwo(form.region_to_id) ? 'isRequired' : ''"
              >
                <option value selected disabled>{{$t('Tanglang')}}</option>
                <option
                  :value="s_item"
                  v-for="(s_item, s_index) in getRegionList"
                  :key="s_index"
                >
                  {{ s_item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-xl-6" v-if="form.region_to_id">
              <label
                for="whereToarea_to_id"
                :class="isRequiredTwo(form.whereTo) ? 'isRequired' : ''"
                >{{$t('Oraliq toʼxtash tuman nomi')}}</label
              >
              <input
                v-model="form.whereTo"
                type="radio"
                name="where_to"
                :value="form.area_to_id"
                id="whereToarea_to_id"
              />
              <select
                class="form-control input_style"
                v-model="form.area_to_id"
                @change="selectArea('area_to_id', 'region_to_id')"
              >
                <option value selected disabled>{{$t('Tanglang')}}</option>
                <option
                  :value="s_item"
                  v-for="(s_item, s_index) in form.areaTo"
                  :key="s_index"
                >
                  {{ s_item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-xl-6" v-if="form.area_to_id">
              <input
                v-model="form.whereTo"
                type="radio"
                name="where_to"
                :value="form.station_to_id"
                id="wherestation_to_id"
              />
              <label
                for="wherestation_to_id"
                :class="isRequired(form.whereTo) ? 'isRequired' : ''"
                >{{$t('Oraliq toʼxtash bekat nomi')}}</label
              >
              <select
                class="form-control input_style"
                v-model="form.station_to_id"
              >
                <option value selected disabled>{{$t('Tanglang')}}</option>
                <option
                  :value="s_item"
                  v-for="(s_item, s_index) in form.stationTo"
                  :key="s_index"
                >
                  {{ s_item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-xl-6">
              <label for="end_speedometer">{{$t('Kelgan vaqtida')}} ({{$t('km')}})</label>
              <input
                type="number"
                v-model="form.end_speedometer"
                id="end_speedometer"
                class="form-control input_style"
                :class="isRequiredTwo(form.end_speedometer) ? 'isRequired' : ''"
                step="0.01"
              />
            </div>
            <div class="form-group col-xl-6 d-flex">
              <div class="form-group col-md-10 pl-0">
                <label for="seria">{{$t('Toʼxtaganda vaqt koʼrsatkichi')}}  </label>
                <date-picker
                  lang="ru"
                  class="input_style"
                  v-model="form.end_time"
                  :type="getDirection.type_id == 5 ? 'datetime' : 'time'"
                  :class="isRequiredTwo(form.end_time) ? 'isRequired' : ''"
                  format="HH:mm:ss"
                ></date-picker>
              </div>
              <div class="form-group col-md-2 pr-0">
                <input type="checkbox" v-model="form.nextDay" id="nextDay" />
                <label for="nextDay">{{$t('Keyingi kun')}}</label>
              </div>
            </div>
            <div class="form-group col-xl-6">
              <label for="distance_in_limited_speed"
                >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}} ({{$t('km')}})</label
              >
              <input
                type="number"
                v-model="form.distance_in_limited_speed"
                id="distance_in_limited_speed"
                class="form-control input_style"
                :class="
                  isRequiredTwo(form.distance_in_limited_speed)
                    ? 'isRequired'
                    : ''
                "
                step="0.01"
              />
            </div>
            <div class="form-group col-xl-6">
              <label for="spendtime_between_limited_space"
                >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}} ({{$t('daqiqa')}})</label
              >
              <input
                type="text"
                v-model="form.spendtime_between_limited_space"
                id="spendtime_between_limited_space"
                class="form-control input_style"
                :class="
                  isRequiredTwo(form.spendtime_between_limited_space)
                    ? 'isRequired'
                    : ''
                "
              />
            </div>
          </div>
          <div class="form-group col-lg-12">
            <div class="row">
              <div class="col-xl-5">
                <button
                  type="button"
                  class="btn btn-success btn_save_category"
                  @click.prevent="sendToActivate"
                >
                  <i class="far fa-share-square"></i>
                  {{$t('Tasdiqlash uchun yuvorish')}}
                </button>
              </div>
              <div class="col-xl-7 form_btn d-flex justify-content-end">
                <div class="form-group mr-3 mb-0">
                  <label for="conclusion">{{$t('Xulosa')}}</label>
                  <select
                    name="conclusion"
                    id="conclusion"
                    v-model="timingDetails.conclusion"
                    :class="
                      isRequired(timingDetails.conclusion) ? 'isRequired' : ''
                    "
                    class="form-control input_style"
                  >
                    <option value="Talablarga javob beradi">
                      {{$t('Talablarga javob beradi')}}
                    </option>
                    <option value="Talablarga javob bermaydi">
                      {{$t('Talablarga javob bermaydi')}}
                    </option>
                  </select>
                </div>
                <button
                  type="button"
                  @click="clearTable()"
                  class="btn btn-danger mr-2"
                  v-if="tableTwoData.length"
                >
                  <i class="fas fa-trash"></i>
                  {{$t('Jadvalni tozalash')}}
                </button>
                <button
                  type="button"
                  @click="addItem()"
                  class="btn btn-info mr-2"
                >
                  <i class="fas fa-plus"></i>
                  {{$t('Qoʼshish')}}
                </button>
                <button type="submit" class="btn btn-primary btn_save_category">
                  <i class="fas fa-save"></i>
                  {{$t('Saqlash')}}
                </button>
              </div>
            </div>
          </div>
          <div id="prindDiv">
          <div class="table-responsive" v-if="tableTwoData.length">
            <table
              class="table table-bordered text-center table-hover table-striped"
              style="border-collapse: collapse;"
            >
              <thead style="border-collapse: collapse;">
                <tr style="border-collapse: collapse;">
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" rowspan="2">№</th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" rowspan="2">{{$t('Oraliq toʼxtash bekatlari')}}</th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" colspan="2">
                    {{$t('Masofa ulagich koʼrsatkichlari')}}
                  </th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" colspan="3">{{$t('Masofa (km)')}}</th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" colspan="3">{{$t('Sariflanadigan vaqt (daqiqa)')}}</th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" scope="col" colspan="2">
                    {{$t('Oʼrtacha texnik tezlik (km/soat)')}}
                  </th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" rowspan="2">{{$t('Qatnov yoʼl xaqidagi maʼlumotlar')}}</th>
                  <th style="border-collapse: collapse;border: 1px solid #292666;border-bottom: 2px solid #292666;padding: 0.25rem;" rowspan="2">{{$t('Tahrirlash')}}</th>
                </tr>
                <tr style="border-collapse: collapse;">
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Joʼnash vaqtida')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Kelgan vaqtida')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Boshlangʼich bekatdan')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Bekatlar oraligʼida')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Bekatlar oraligʼidagi xarakat')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Oraliq bekatda toʼxtash uchun')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Bekatlar oraligʼidagi xarakat')}}</th>
                  <th style="border: 1px solid #292666;border-collapse: collapse;border-bottom: 2px solid #292666;padding: 0.25rem;" >{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(table, index) in tableTwoData">
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" scope="row">{{ index + 1 }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">
                    {{ table.whereForm ? table.whereForm.name : "" }}
                    {{ table.whereTo ? table.whereTo.name : "" }}
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.start_speedometer }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.end_speedometer }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.distance_from_start_station }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.distance_between_station }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.distance_in_limited_speed }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.spendtime_between_station }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.spendtime_between_limited_space }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">
                    {{
                      table.spendtime_to_stay_station == 0
                        ? "00:00:00"
                        : table.spendtime_to_stay_station
                    }}
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.speed_between_station }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">{{ table.speed_between_limited_space }}</td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" class="detail_td">
                    <span v-for="detail in table.details">
                      {{ detail.sign ? detail.sign.name : "" }}
                      {{ detail.count }}
                      <b>,</b>
                    </span>
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;">
                    <button
                      v-if="index == tableTwoData.length - 1"
                      class="btn_transparent"
                      type="button"
                      @click="deletTableItem(index)"
                    >
                      <i class="pe_icon pe-7s-trash trashColor"></i>
                    </button>
                  </td>
                </tr>
                <tr >
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" colspan="7" scope="row">
                    {{$t('Oʼrtacha tezlik')}} = {{ technic_speed }} {{$t('km/soat')}}
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" colspan="1" scope="row">
                    {{ total_spendtime_between_station }}
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" colspan="1" scope="row"></td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" colspan="1" scope="row">
                    {{ total_spendtime_to_stay_station }}
                  </td>
                  <td style="padding: 0.25rem;border: 1px solid #292666;text-align:center;" colspan="5" scope="row">
                    {{$t('Qatnov tezlik')}} = {{ traffic_speed }} {{$t('km/soat')}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table_footer" style="display: flex;justify-content: space-between;align-items: flex-start;">
            <div class="col-xl-6" style="width: 50%;">
              <p>
                {{$t('Qatnov yoʼli xarakat xafsizligiga')}}: {{ timingDetails.conclusion }}
              </p>
              <p>{{$t('Oʼlchov oʼtkazilgan kun')}}: {{ timingDetails.date }} {{$t('yil')}}</p>
              <p>
                {{$t('Xronametraj oʼtkazilgan avtomobil rusumi va davlat raqami')}}:
                {{ timingDetails.avto_model }}, {{ timingDetails.avto_number }}
              </p>
            </div>
            <div class="col-xl-4 right_item" style="width: 33%;display: flex;justify-content: space-between;align-items: flex-start;">
              <div>
                <p>
                  {{$t('Oʼlchov')}} <br />
                 {{$t('qatnashchilari')}}  <br />
                  {{$t('imzolari')}}:
                </p>
              </div>
              <div>
                <p v-for="(person, index) in timingDetails.persons">
                  {{ person.name.charAt(0) }}.{{ person.surname }}
                </p>
              </div>
            </div>
          </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "./PassportTab";
import Loader from "../../Loader";
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader,
  },
  data() {
    return {
      titulData: [],
      form: {
        direction_id: this.$route.params.directionId,
        region_from_id: "",
        region_to_id: "",
        area_from_id: "",
        area_to_id: "",
        station_from_id: "",
        station_to_id: "",
        start_time: "",
        end_time: "",
        start_speedometer: "", //Jonash vaqtida
        end_speedometer: "", //Kelgan vaqtida
        distance_from_start_station: "", //Boshlangich bekatdan
        distance_between_station: "", //Bekatlar oraligida
        distance_in_limited_speed: "", //Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_between_station: "", //Bekatlar oraligidagi xarakat
        spendtime_between_limited_space: "", //Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_to_stay_station: "00:00:00", //Oraliq bekatdan toxtash uchun
        speed_between_station: "", //Bekatlar oraligidagi xarakat
        speed_between_limited_space: "", //Shundan xarakat tezligi chegaralangan oraliqda
        details: [{ name: "", count: "" }], //Qatnov yoli xaqidagi malumotlar
        areaFrom: [],
        stationFrom: [],
        stationTo: [],
        areaTo: [],
        whereForm: "",
        whereTo: "",
        detailsOptions: [],
        nextDay: false,
      },
      timingDetails: {
        date: "",
        avto_number: "",
        avto_model: "",
        conclusion: "",
        persons: [
          { name: "", surname: "", job: "", position: "" },
          { name: "", surname: "", job: "", position: "" },
          { name: "", surname: "", job: "", position: "" },
        ],
      },
      tableTwoData: [],
      requiredInput: false,
      requiredInputTwo: false,
      technic_speed: 0,
      traffic_speed: 0,
      total_spendtime_between_station: "00:00:00",
      total_spendtime_to_stay_station: "00:00:00",
      laoding: true,
      fullTableInfo: [],
      errorInput: true,
    };
  },
  async mounted() {
    await this.actionEditDirection(this.$route.params.directionId);
    await this.actionRegionList();
    await this.actionConditionalSignList();
    this.form.detailsOptions = this.getConditionalSignList;
    this.laoding = false;
    this.titulData = this.getDirection;

    this.timingDetails = this.titulData.timing_details.length
      ? this.titulData.timing_details[0]
      : this.timingDetails;
    if (this.titulData.timing_with.length) {
      this.fullTableInfo = JSON.parse(this.timingDetails.vars);
      this.calcTableData();
      this.calctechnic_speed();
    } else {
      this.form.region_from_id = this.titulData.region_from_with;
      this.form.area_from_id = this.titulData.area_from_with;
      this.form.station_from_id = this.titulData.station_from_id;
      this.form.whereForm = this.titulData.from_where;
    }
    this.timingDetails.date = this.$g.getDate(this.timingDetails.date);
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("conditionalsign", ["getConditionalSignList"]),
    ...mapGetters("area", ["getAreaXromLists"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("passportTab", ["getTimingMassage"]),
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("confirmtiming", ["getTimingConfirmMassage"]),
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("conditionalsign", ["actionConditionalSignList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionXromAreaList"]),
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable"]),
    ...mapActions("confirmtiming", ["actionApproveTiming"]),
    async sendToActivate() {
        this.laoding = true;
        await this.actionApproveTiming(this.$route.params.directionId);
        if (this.getTimingConfirmMassage.success) {
            await this.actionEditDirection(this.$route.params.directionId);
            toast.fire({
            type: "success",
            icon: "success",
            title: this.getTimingConfirmMassage.message,
            });
        } else {
            toast.fire({
            type: "error",
            icon: "error",
            title: this.getTimingConfirmMassage.message,
            });
        }
        this.laoding = false;
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    isRequiredTwo(input) {
      return this.requiredInputTwo && input === "";
    },
    async selectArea(this_select, parent_select) {
      this.laoding = true;
      await this.actionStationByRegion({
        region_id: this.form[parent_select].id,
        area_id: this.form[this_select].id,
      });
      this.laoding = false;
      if (this_select == "area_from_id") {
        this.form.stationFrom = this.getStationsList;
      } else if (this_select == "area_to_id") {
        this.form.stationTo = this.getStationsList;
      }
    },
    async selectRegion(input) {
      await this.actionXromAreaList({ region_id: this.form[input].id });
      if (input == "region_from_id") {
        this.form.areaFrom = this.getAreaXromLists;
      } else if (input == "region_to_id") {
        this.form.areaTo = this.getAreaXromLists;
      }
    },
    calctechnic_speed() {
      let calc_technic_speed = "00:00:00";
      let calc_traffic_speed = "00:00:00";
      let calc_spendtime_between_station = "00:00:00";
      let calc_spendtime_to_stay_station = "00:00:00";
      this.tableTwoData.forEach((item) => {
        calc_technic_speed = this.calcTimeAddTime(
          calc_technic_speed,
          item.spendtime_between_station == 0
            ? "00:00:00"
            : item.spendtime_between_station
        );
        calc_traffic_speed = this.calcTimeAddTime(
          calc_traffic_speed,
          item.spendtime_to_stay_station == 0
            ? "00:00:00"
            : item.spendtime_to_stay_station
        );
        calc_spendtime_between_station = this.calcTimeAddTime(
          calc_spendtime_between_station,
          item.spendtime_between_station == 0
            ? "00:00:00"
            : item.spendtime_between_station
        );
        calc_spendtime_to_stay_station = this.calcTimeAddTime(
          calc_spendtime_to_stay_station,
          item.spendtime_to_stay_station == 0
            ? "00:00:00"
            : item.spendtime_to_stay_station
        );
      });
      this.technic_speed =
        (this.tableTwoData[this.tableTwoData.length - 1]
          .distance_from_start_station *
          60) /
        this.timeToMinuts(calc_technic_speed);
      this.traffic_speed =
        (this.tableTwoData[this.tableTwoData.length - 1]
          .distance_from_start_station *
          60) /
        (this.timeToMinuts(calc_technic_speed) +
          this.timeToMinuts(calc_traffic_speed));
      this.technic_speed = parseFloat(this.technic_speed).toFixed(1);
      this.traffic_speed = parseFloat(this.traffic_speed).toFixed(1);
      this.total_spendtime_between_station = calc_spendtime_between_station;
      this.total_spendtime_to_stay_station = calc_spendtime_to_stay_station;
    },
    signSelect(detail) {
      detail.name = detail.sign.id;
    },
    timeToMinuts(time) {
      var a = time.split(":");
      var minut = +a[0] * 60 + +a[1];
      return minut;
    },
    addItem() {
      if (
        this.form.start_time != "" &&
        this.form.speed_between_station != "" &&
        this.form.speed_between_limited_space != "" &&
        this.form.end_speedometer != "" &&
        this.form.end_time != "" &&
        this.form.distance_in_limited_speed != "" &&
        this.form.spendtime_between_limited_space != "" &&
        this.form.region_to_id != "" &&
        this.form.whereTo != ""
      ) {
        let thisData = {};
        this.fullTableInfo.push(this.form);
        this.calcTableData();
        this.calctechnic_speed();
        this.requiredInputTwo = false;
      } else {
        this.requiredInputTwo = true;
      }
    },
    calcTableData() {
      let dataTable = this.fullTableInfo;

      this.tableTwoData = [];
      dataTable.forEach((element, index) => {
        element.nextDay =
          element.nextDay != undefined ? element.nextDay : false;
        if (index == 0) {
          element.distance_from_start_station = parseFloat(
            element.end_speedometer - element.start_speedometer
          ).toFixed(1);
        } else {
          element.distance_from_start_station = parseFloat(
            element.end_speedometer - this.tableTwoData[0].start_speedometer
          ).toFixed(1);
          let result_spendtime_to_stay_station = this.calcTimeToTime(
            this.tableTwoData[this.tableTwoData.length - 1].end_time,
            element.start_time,
            false
          );
          element.spendtime_between_station = result_spendtime_to_stay_station;
          this.tableTwoData[
            this.tableTwoData.length - 1
          ].spendtime_to_stay_station = result_spendtime_to_stay_station;
        } //else
        element.distance_between_station = (
          element.end_speedometer - element.start_speedometer
        ).toFixed(1);
        let result_spendtime_between_station = this.calcTimeToTime(
          element.start_time,
          element.end_time,
          element.nextDay
        );
        element.spendtime_between_station = result_spendtime_between_station;
        this.tableTwoData.push(element);
      });
      let thisData;
      thisData = {
        direction_id: this.$route.params.directionId,
        region_from_id: this.fullTableInfo[this.fullTableInfo.length - 1]
          .region_to_id,
        region_to_id: "",
        area_from_id: this.fullTableInfo[this.fullTableInfo.length - 1]
          .area_to_id,
        area_to_id: "",
        station_from_id: this.fullTableInfo[this.fullTableInfo.length - 1]
          .station_to_id,
        station_to_id: "",
        start_time: "",
        end_time: "",
        start_speedometer: this.fullTableInfo[this.fullTableInfo.length - 1]
          .end_speedometer,
        end_speedometer: "",
        distance_from_start_station:
          this.fullTableInfo.length == 1
            ? parseFloat(
                this.fullTableInfo[this.fullTableInfo.length - 1]
                  .end_speedometer -
                  this.fullTableInfo[this.fullTableInfo.length - 1]
                    .start_speedometer
              ).toFixed(1)
            : parseFloat(
                this.form.end_speedometer -
                  this.tableTwoData[0].start_speedometer
              ).toFixed(1),
        distance_between_station:
          this.fullTableInfo.length > 1
            ? this.form.end_speedometer - this.form.start_speedometer
            : "", //d
        distance_in_limited_speed: "",
        spendtime_between_station: "",
        spendtime_between_limited_space: "",
        spendtime_to_stay_station: "00:00:00",
        speed_between_station: "",
        speed_between_limited_space: "",
        details: [{ name: "", count: "" }],
        areaFrom: [],
        stationFrom: [],
        stationTo: [],
        areaTo: [],
        whereForm: this.fullTableInfo[this.fullTableInfo.length - 1].whereTo,
        whereTo: "",
        detailsOptions: this.getConditionalSignList,
        nextDay: false,
      };
      this.form = thisData;
    },
    addDetail() {
      this.form.details.push({ name: "", count: "" });
    },
    deletTableItem(inx) {
      this.fullTableInfo.splice(inx, 1);
      this.calcTableData();
      this.calctechnic_speed();
    },
    removeDetail(index) {
      this.form.details.splice(index, 1);
    },
    toTimestamp(strDate) {
      var datum = Date.parse(strDate);
      return datum / 1000;
    },
    async saveData() {
      if (
        this.timingDetails.date != "" &&
        this.timingDetails.avto_number != "" &&
        this.timingDetails.conclusion != "" &&
        this.timingDetails.avto_model != "" &&
        this.timingDetails.persons[0].name != "" &&
        this.timingDetails.persons[0].surname != "" &&
        this.timingDetails.persons[0].position != "" &&
        this.timingDetails.persons[1].name != "" &&
        this.timingDetails.persons[1].surname != "" &&
        this.timingDetails.persons[1].position != "" &&
        this.timingDetails.persons[2].name != "" &&
        this.timingDetails.persons[2].surname != "" &&
        this.timingDetails.persons[2].position != ""
      ) {
        this.requiredInput = false;
        if (this.tableTwoData.length) {
          this.laoding = true;
          await this.actionAddTiming({
            vars: JSON.stringify(this.fullTableInfo),
            timing: this.tableTwoData,
            timingDetails: this.timingDetails,
            technic_speed: this.technic_speed,
            traffic_speed: this.traffic_speed,
          });
          this.laoding = false;
          if (this.getTimingMassage.success) {
            toast.fire({
              type: "success",
              icon: "success",
              title: this.getTimingMassage.message,
            });
          } else {
            toast.fire({
              type: "error",
              icon: "error",
              title: this.getTimingMassage.message,
            });
          }
        } else {
          toast.fire({
            type: "error",
            icon: "error",
            title: this.$t('Jadval bo‘sh bo‘lmasligi kerak'),
          });
        }
      } else {
        this.requiredInput = true;
        toast.fire({
          type: "error",
          icon: "error",
          title: this.$t('Qizil bilan belgilangan polyalarini  toldiring'),
        });
      }
    },
    addPerson() {
      let thisDate = { name: "", surname: "", job: "", position: "" };
      this.timingDetails.persons.push(thisDate);
    },
    removePerson(index) {
      this.timingDetails.persons.splice(index, 1);
    },
    calcTimeToTime(start, end, nextday = false) {
      let starttime = new Date(start);
      let endtime = new Date(end);
      if (nextday) {
        endtime.setDate(endtime.getDate() + 1);
      }
      let elapsed = endtime.getTime() - starttime.getTime();
      let ms = elapsed % 1000;
      elapsed = (elapsed - ms) / 1000;
      let secs = elapsed % 60;
      secs = secs <= 9 ? "0" + secs : secs;
      elapsed = (elapsed - secs) / 60;
      let mins = elapsed % 60;
      mins = mins <= 9 ? "0" + mins : mins;
      let hrs = (elapsed - mins) / 60;
      hrs = (elapsed - mins) / 60 <= 9 ? "0" + hrs : hrs;
      let res = hrs + ":" + mins + ":" + secs;
      return res;
    },
    calcTimeAddTime(oldTime, newTime) {
      // oldTime
      let oldHour = Number(oldTime.split(":")[0]) * 3600;
      let oldMin = Number(oldTime.split(":")[1]) * 60;
      let oldSec = Number(oldTime.split(":")[2]);
      let oldResult = oldHour + oldMin + oldSec;
      // newTime
      let newHour = Number(newTime.split(":")[0]) * 3600;
      let newMin = Number(newTime.split(":")[1]) * 60;
      let newSec = Number(newTime.split(":")[2]);
      let newResult = newHour + newMin + newSec;

      let summ = oldResult + newResult;

      let hours = Math.floor(summ / 60 / 60);
      let minutes = Math.floor(summ / 60) - hours * 60;
      let seconds = summ % 60;

      let HourName = hours < 10 ? "0" + hours.toString() : hours;
      let MinuteName = minutes < 10 ? "0" + minutes.toString() : minutes;
      let SecondName = seconds < 10 ? "0" + seconds.toString() : seconds;
      return HourName + ":" + MinuteName + ":" + SecondName;
    },
    async clearTable() {
      window.swal
        .fire({
          title: this.$t("Ishonchingiz komilmi"),
          text: "Siz buni qaytarib ololmaysiz!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: this.$t("Oʼchirish"),
          cancelButtonText: this.$t('Bekor qilish'),
        })
        .then(async (result) => {
          if (result.value) {
            await this.clearTimingTable(this.$route.params.directionId);
            if (this.getTimingMassage.success) {
              this.tableTwoData = [];
              window.swal.fire("O'chirildi!", "Ma'lumotlaringiz o'chirildi.");
            }
          }
        });
    },
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.double_input {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}
.triple_input label,
.double_input label {
  width: 100%;
}
.double_input select,
.double_input input {
  width: 49%;
}
.triple_input {
  display: flex;
  flex-wrap: wrap;
}
.triple_input select {
  width: 30%;
  margin-right: 15px;
}
.triple_input input {
  width: 58%;
  margin-right: 15px;
}
.tabs_block {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  border-bottom: 1px solid #000;
  margin-bottom: 30px;
}
.detail_td span:last-child b {
  display: none;
}
.form-group {
  align-self: flex-end;
}
.table_footer {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  width: 100%;
}
.table_footer .right_item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}
.table_footer p {
  font-weight: bold;
  font-size: 16px;
}
.table_btn {
  width: 30px;
  height: 30px;
  font-size: 10px;
  padding: 1px;
}
</style>
