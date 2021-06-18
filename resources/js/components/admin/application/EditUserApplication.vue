<template>
  <div class="add_region">
        <Loader v-if="laoding"/>
    <div class="card">
        <div class="card-header">
          <h4 class="title_user">
            <i class="peIcon fas fa-file"></i>
            {{$t('Arizani tekshirish')}}
        </h4>
        <div class="">
          <h4 class="title_user" v-if="direction_ids.length > 0" v-for="(item,index) in direction_ids">
            {{index+1}}) {{  item.name }}
          </h4>
        </div>
        <div class="d-flex">
          <span class="qr_code" @click.prevent="openQrcode" v-if="makeDisabled">
            <i class="fas fa-qrcode"></i>
          </span>
          <router-link class="btn btn-primary back_btn" to='/crm/user/application'>
            <span class="peIcon pe-7s-back"></span>
             {{$t('Orqaga')}}
          </router-link>
        </div>
        </div>
        <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h2><em>{{$t('Tashkilot nomi')}}:</em> <b>{{form.user ? form.user.company_name : ''}}</b></h2>
          </div>
        </div>
        <div class="row" v-if="form.tarif && form.tarif.length" v-for="(item,index) in direction_ids">
          <div class="col-md-3">
                        <label >{{$t('Yoʼnalish nomi')}}</label>
                        <input
                type="text"
                class="form-control input_style"
                            :value="item.name"
                disabled>
          </div>
          <div class="form-group col-md-3">
              <label for="tarif">{{$t('Tarif')}} ({{$t('Yoʼl haqqi')}})</label>
              <div class="d-flex align-items-center">
                <input
                type="number"
                class="form-control input_style"
                id="tarif"
                v-model="form.tarif[index].summa"
                :class="isRequiredData(form.tarif[index].summa) ? 'isRequired' : ''"
                :disabled="makeDisabled">
            </div>
            </div>
            <div class="form-group col-md-3">
              <label for="qty_reys">{{$t('Reyslar soni')}}</label>
              <input
                type="number"
                class="form-control input_style"
                id="qty_reys"
                v-model="form.qty_reys[index].qty"
                :class="isRequiredData(form.qty_reys[index].qty) ? 'isRequired' : ''"
                :disabled="makeDisabled">
          </div>
                    <div class="form-group col-md-3 btn_save d-flex justify-content-end" v-if="!makeDisabled">
              <button type="button" class="btn btn-secondary mr-3" @click.prevent="openModal(item)">
                <i class="fas fa-plus"></i>
                {{$t('Avtomobil qoʼshish')}}
              </button>
            </div>
        </div>
          <form enctype="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-3 d-flex align-items-center mt-4">
              <button
                  type="button"
                  class="btn btn-outline-info"
                  @click.prevent="showDirections =! showDirections"
                >
                  <i class="fas fa-route"></i>
                  {{$t('Marshrutlar')}}
                  <i class="pe-7s-angle-down-circle"></i>
                </button>
              </div>
                <!-- <div class="form-group col-md-2 btn_save d-flex justify-content-end" v-if="!makeDisabled">
                  <button type="button" class="btn btn-secondary mr-3" @click.prevent="openModal">
                  <i class="fas fa-plus"></i>
                  {{$t('Qoʼshish')}} авто
                  </button>
                </div> -->
          </div>
          <div class="row" v-if="showDirections">
            <div class="col-md-12">
              <div class="table-responsive" v-if="direction_ids.length > 0">
                  <div class="d-flex justify-content-center">
                    <h4>{{$t('Marshrutlar')}}</h4>
                  </div>
                  <div class="choosenItemsTable">
                    <ul v-for="(items,index) in direction_ids">
                      <h3><em>{{index+1}})</em> <strong>{{$t('Marshrut')}}</strong>: <em>{{items.name}}</em> <small>({{ items.reys_status == 'all' ? $t('Toʼliq') : $t('Qisman') }})</small> </h3>
                        <template>
                          <li class="mb-2">
                            <h4><em>{{$t('Tomonidan')}}:</em>  <b>{{items.reysesFrom[0].where.name}}</b></h4>
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
                                :class="activeEditClass(reys) ? 'active' : ''"
                              >
                                <td>{{key+1}}</td>
                                <template v-for="(val,key) in reys.reys_times">
                                  <td>{{val.start}}</td>
                                  <td>{{val.end}}</td>
                                </template>
                              </tr>
                            </tbody>
                          </table>
                        </li>
                          <li>
                            <h4><em>Со стороны:</em>  <b>{{items.reysesTo[0].where.name}}</b></h4>
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
                                :class="activeEditClass(reys) ? 'active' : ''"
                              >
                                <td>{{key+1}}</td>
                                <template v-for="(val,key) in reys.reys_times">
                                  <td>{{val.start}}</td>
                                  <td>{{val.end}}</td>
                                </template>
                              </tr>
                            </tbody>
                          </table>
                        </li>
                        </template>
                        <hr>
                    </ul>
                  </div>
                </div>
            </div>
          </div>
          <div class="row">
              <div class="form-group col-md-12 table table-responsive">
                <div class="d-flex justify-content-center">
                  <h4 class="app_title">
                    {{$t('Yoʼnalishlarda ishlayotganda harakatlanish xavfsizligini taʼminlash boʼyicha qatnashchi tomonidan amalga oshirilgan tadbirlar rejasi quyidagicha baholanadi')}}
                  </h4>
              </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th width="1%">1</th>
                      <th width="50%">
                         {{$t('Аvtotransport vositalarini xar kuni reysdan oldingi texnik koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                      </th>
                      <th>
                        <input
                          type="checkbox"
                          name="daily_technical_job"
                          true-value="1"
                        false-value="0"
                          v-model="form.daily_technical_job"
                          :disabled="makeDisabled"
                        >
                      </th>
                    </tr>
                    <tr>
                      <th>2</th>
                      <th width="50%">
                        {{$t('Haydovchilarni har kungi tibbiy koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                      </th>
                      <th>
                        <input
                          type="checkbox"
                          name="daily_medical_job"
                          true-value="1"
                        false-value="0"
                          v-model="form.daily_medical_job"
                          :disabled="makeDisabled"
                        >
                      </th>
                    </tr>
                    <tr>
                      <th>3</th>
                      <th width="50%">
                        {{$t('Taklif etilgan avtotransport vositalari sonidan kelib chiqib barcha haydovchilariga 30 soatlik dastur boʼyicha yoʼl harakati qoidalarini oʼrgatilgan')}}
                      </th>
                      <th>
                        <input
                          type="checkbox"
                          name="hours_rule"
                          true-value="1"
                        false-value="0"
                          v-model="form.hours_rule"
                          :disabled="makeDisabled"
                        >
                      </th>
                    </tr>
                    <tr>
                      <th>4</th>
                      <th width="50%">
                        {{$t('Taklif etilgan barcha avtotransport vositalarining old oynalariga videoregistrator oʼrnatilgan')}}
                      </th>
                      <th>
                        <input
                          type="checkbox"
                          name="videoregistrator"
                          true-value="1"
                        false-value="0"
                          v-model="form.videoregistrator"
                          :disabled="makeDisabled"
                        >
                      </th>
                    </tr>
                    <tr>
                      <th>5</th>
                      <th width="50%">
                        {{$t('Taklif etilgan barcha avtotransport vositalarini GPS rejimida masofadan kuzatish tizimiga ulangan')}}
                      </th>
                      <th>
                        <input
                          type="checkbox"
                          name="gps"
                          true-value="1"
                        false-value="0"
                          v-model="form.gps"
                          :disabled="makeDisabled"
                        >
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="form-group col-lg-12" v-if="form.hours_rule == 1">
                <div class="row pl-3">
                  <!-- <div class="form-group col-md-3">
                    <input
                              type="file"
                              class="form-control"
                              id="image"
                              accept=".png, .jpg, .jpeg"
                              @change="changePhoto($event)"
                            />
                  </div> -->
                                <div class=" input-group input_group_with_label input_file col-md-3">
                                    <input
                              type="file"
                              class="form-control"
                              id="image"
                              accept=".png, .jpg, .jpeg"
                              @change="changePhoto($event)"
                                    />
                                    <p>{{ file ? file.name : ''}}</p>
                                    <label for="file"> {{$t('contacts_page.file_upload')}}</label>
                                </div>
                  <div class="form-group col-md-2">
                    <button type="button" class="btn btn-info text-white" @click.prevent="addFile">
                      <i class="fas fa-plus"></i>
                      {{$t('file_upload')}}
                    </button>
                  </div>
                  <div class="form-group col-md-12" v-if="files.length > 0">
                    <ul class="list-inline d-flex">
                        <li v-for="(f_name,index) in files" class="mr-4">
                        <a :href="'/'+f_name.path+'/'+f_name.hash" title="" download="" class="btn btn-outline-dark">
                          <i class="fas fa-download"></i>
                          {{f_name.original_name}}
                        </a>
                        <!-- <button type="button" class="btn btn-danger" @click.prevent="removeFile(f_name.id)">
                          <i class="pe_icon pe-7s-trash trashColor"></i>
                        </button> -->
                        </li>
                    </ul>
                  </div>
                </div>
              </div>
            <div class="form-group col-md-12 table table-responsive" v-if="cars_with.length > 0">
              <div class="d-flex justify-content-center">
                <h4>{{$t('Mening avtomobillarim')}}</h4>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>№</th>
                    <th>{{$t('Yoʼnalish nomi')}}</th>
                    <th>{{$t('Avtomobil raqami')}}</th>
                    <th>{{$t('Avtomobil turi')}}</th>
                    <th>{{$t('Avtomobil sinfi')}}</th>
                    <th>{{$t('Avtomobil rusumi')}}</th>
                    <th>{{$t('Avtobus markasi')}}</th>
                    <th>{{$t('Ishlab chiqarilgan sana')}}</th>
                    <th>{{$t('capacity')}}</th>
                    <th>{{$t('Oʼrindiqlar soni')}}</th>
                    <th>{{$t('Tahrirlash')}}</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(car,index) in cars_with">
                    <tr>
                      <td>{{index+1}}</td>
                      <td>{{car.direction.name}}</td>
                      <td>{{car.auto_number}}</td>
                      <td>{{car.bustype.name}}</td>
                      <td>{{car.tclass.name}}</td>
                      <td>{{car.busmarka ? car.busmarka.name : ''}}</td>
                      <td>{{car.busmodel ? car.busmodel.name : '' }}</td>
                      <td>{{car.date}}</td>
                      <td>{{car.capacity}}</td>
                      <td>{{car.seat_qty}}</td>
                      <td>
                        <button type="button" class="btn_transparent" @click.prevent="showTable(index)">
                          <i class="pe-7s-angle-down-circle"></i>
                        </button>
                    <!--     <button type="button" class="btn_transparent" @click.prevent="deleteCar(car.id)">
                          <i class="pe_icon pe-7s-trash trashColor"></i>
                        </button> -->
                      </td>
                    </tr>
                    <tr v-if="showBtn == index">
                      <td colspan="11">
                        <table class="table table-bordered" v>
                            <thead>
                              <tr>
                                <th width="1%">1</th>
                                <th width="80%">{{$t('Sovutgich (iqlim-nazorati tizimi)')}}</th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.conditioner == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>2</th>
                                <th width="80%">{{$t('Internet')}}</th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.internet == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>3</th>
                                <th width="80%">{{$t('Bioxojatxona')}} </th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.bio_toilet == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>4</th>
                                <th width="80%">
{{$t('Аvtobusning nogironlarga va aholining boshqa xarakatlanishi cheklangan guruxlariga moslashganligi')}}
                                </th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.bus_adapted == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>5</th>
                                <th width="80%">
                                  {{$t('Telefon quvvatlagichlari')}}
                                </th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.telephone_power == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>6</th>
                                <th width="80%">
                                  {{$t('Xar bir oʼrindiqda monitor (planshet)')}}
                                </th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.monitor == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                              <tr>
                                <th>7</th>
                                <th width="80%">
                                  {{$t('Bekatlarni eʼlon qilish audio tizimi')}}
                                </th>
                                <th>
                                  <i
                                    class="fas text-success"
                                    :class="car.station_announce == 1 ? ' fa-check-circle' : ''"
                                  ></i>
                                </th>
                              </tr>
                            </thead>
                          </table>
                      </td>
                    </tr>
                  </template>
                    <tr>
                      <td colspan="8">
                       {{$t('Natijalar')}} :
                      </td>
                      <td>
                        {{countCapacity}}
                      </td>
                      <td>
                        {{countSeatQty}}
                      </td>
                      <td>...</td>
                    </tr>
                </tbody>
              </table>
            </div>
              <div class="form-group col-lg-12 d-flex justify-content-end align-items-end" v-if="!makeDisabled">
                <div class="form-group col-md-3 mb-0" v-if="old_contract_time">
                    <label> {{$t('Muddat')}}</label>
                    <select  class="form-control"  v-model="contract_time">
                        <option v-for="option in timeOptions" :value="option.val" v-if="old_contract_time >= option.val">
                          {{ option.name }}
                        </option>
                    </select>
                </div>
                <router-link :to='`/crm/application/user/${$route.params.userapplicationId}`' class="btn btn-secondary mr-3">
                  <i class="fas fa-save"></i>
                  {{$t('Davom ettirish')}}
                </router-link>
                <button type="button" class="btn btn-primary btn_save_category" @click.prevent="activate">
                  <i class="far fa-share-square"></i>
                  {{$t('Yuvorish')}}
              </button>
                </div>
          </div>
        </form>
        </div>
      </div>
      <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Новое авто</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-3">
              <label for="auto_number">{{$t('Avtomobil raqami')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="auto_number"
                v-mask="'********'"
                v-model="car.auto_number"
                :class="isRequired(car.auto_number) ? 'isRequired' : ''"
              >
            </div>
            <div class="form-group col-md-3">
              <label for="bustype_id">{{$t('Avtomobil turi')}}</label>
              <select
                class="form-control input_style"
                id="bustype_id"
                v-model="car.bustype_id"
                :class="isRequired(car.bustype_id) ? 'isRequired' : ''"
                            @change="selectBustype(car.bustype_id)"
              >
                <option value="" selected disabled>{{$t('Avtomobil turini tanlang')}}!</option>
                <option
                  :value="busType.id"
                  v-for="(busType,index) in getTypeofbusList"
                  data-toggle="tooltip" data-placement="right" title="Tooltip on right"
                >{{busType.name}}</option>
              </select>
              <!-- @change="selectClass(car.bustype_id)" -->
            </div>
                    <div class="form-group col-md-3">
              <label for="tclass_id">{{$t('Avtomobil sinfi')}}</label>
              <select
                class="form-control input_style"
                id="tclass_id"
                v-model="car.tclass_id"
                :class="isRequired(car.tclass_id) ? 'isRequired' : ''"
                @change="selectClass(car.tclass_id)"
              >
                <option value="" selected disabled>{{$t('Avtomobil sinfini tanlang')}}!</option>
                <option :value="busClass.id" v-for="(busClass,index) in getBusclassFindList">{{busClass.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="busmarka_id">{{$t('Avtobus markasi')}}</label>
              <select
                class="form-control input_style"
                id="busmarka_id"
                v-model="car.busmarka_id"
                :class="isRequired(car.busmarka_id) ? 'isRequired' : ''"
                @change="selectCarMarka(car)"
              >
                <option value="" selected disabled>{{$t('Avtomobil turini tanlang')}}!</option>
                <!-- <option :value="item.marka.id" v-for="(item,index) in getBusBrandList">{{item.marka.name}}</option> -->
                <option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
              </select>
                        <!-- @change="selectModel(car.busmarka_id)" -->
            </div>
            <div class="form-group col-md-3">
              <label for="busmodel_id">{{$t('Avtomobil rusumi')}}</label>
              <select
                class="form-control input_style"
                id="busmodel_id"
                placeholder="Номер Авто"
                v-model="car.busmodel_id"
                :class="isRequired(car.busmodel_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>{{$t('Avtomobil rusumini tanlang')}}!</option>
                <!-- <option :value="item.model.id" v-for="(item,index) in bus_models">{{item.model.name}}</option> -->
                <option :value="item.id" v-for="(item,index) in getBusmodelFindList">{{item.name}}</option>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label for="date">{{$t('Ishlab chiqarilgan sana')}}</label>
              <date-picker
                      lang="ru"
                      type="year"
                      v-model="car.date"
                      valueType="format"
                      class="input_style"
                      :class="isRequired(car.date) ? 'isRequired' : ''"
                          :disabled="car.bustype_id ==''"
                          :disabled-date="notBeforeYear"
                          @input="checkDate(car.date)"
                    ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="capacity">{{$t('capacity')}}</label>
              <input
                type="number"
                class="form-control input_style"
                id="capacity"
                v-model="car.capacity"
                max="999"
                :class="isRequired(car.capacity) ? 'isRequired' : ''"
              >
            </div>
            <div class="form-group col-md-3">
              <label for="seat_qty">{{$t('Oʼrindiqlar soni')}}</label>
              <input
                type="number"
                class="form-control input_style"
                id="seat_qty"
                v-model="car.seat_qty"
                :class="isRequired(car.seat_qty) ? 'isRequired' : ''"
              >
            </div>
            <div class="form-group col-md-12 table table-responsive">
              <table class="table table-bordered" v-if="car.bustype_id != 1">
                <thead>
                  <tr>
                    <th width="1%">1</th>
                    <th width="80%">{{$t('Sovutgich (iqlim-nazorati tizimi)')}}</th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.conditioner"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>2</th>
                    <th width="80%">{{$t('Internet')}}</th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.internet"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>3</th>
                    <th width="80%">{{$t('Bioxojatxona')}} </th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.bio_toilet"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>4</th>
                    <th width="80%">
{{$t('Аvtobusning nogironlarga va aholining boshqa xarakatlanishi cheklangan guruxlariga moslashganligi')}}
                    </th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.bus_adapted"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>5</th>
                    <th width="80%">
                      {{$t('Telefon quvvatlagichlari')}}
                    </th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.telephone_power"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>6</th>
                    <th width="80%">
                      {{$t('Xar bir oʼrindiqda monitor (planshet)')}}
                    </th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.monitor"
                      >
                    </th>
                  </tr>
                  <tr>
                    <th>7</th>
                    <th width="80%">
                      {{$t('Bekatlarni eʼlon qilish audio tizimi')}}
                    </th>
                    <th>
                      <input
                        type="checkbox"
                        true-value="1"
                      false-value="0"
                        v-model="car.station_announce"
                      >
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="form-group col-md-2">
                  <label for="owner">{{$t('Egasi')}}</label>
                  <input
                    type="radio"
                    name="gps"
                    value="owner"
                    id="owner"
                    v-model="car.owner_type"
                  >
                </div>
                <div class="form-group col-md-2">
                  <label for="rent">{{$t('Ijara')}}</label>
                  <input
                    type="radio"
                    name="gps"
                    value="rent"
                    id="rent"
                    v-model="car.owner_type"
                  >
                </div>
              </div>
            </div>
            <div class="col-md-12" v-if="car.owner_type == 'owner'">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="pTexpassportSery">{{$t('Texpasport seriyasi')}}</label>
                  <input
                    type="text"
                    class="form-control input_style"
                    id="pTexpassportSery"
                    v-model="car.pTexpassportSery"
                    :class="isRequired(car.pTexpassportSery) ? 'isRequired' : ''"
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="pTexpassportNumber">{{$t('Texpasport raqami')}}</label>
                  <input
                    type="number"
                    class="form-control input_style"
                    id="pTexpassportNumber"
                    v-model="car.pTexpassportNumber"
                    :class="isRequired(car.pTexpassportNumber) ? 'isRequired' : ''"
                  >
                </div>
              </div>
            </div>
            <div class="col-md-12" v-if="car.owner_type == 'rent'">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="pNumberNatarius">{{$t('Notarius hujjat reestr raqami')}}</label>
                  <input
                    type="text"
                    class="form-control input_style"
                    id="pNumberNatarius"
                    v-model="car.pNumberNatarius"
                    :class="isRequired(car.pNumberNatarius) ? 'isRequired' : ''"
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="pDateNatarius">{{$t('Notarius hujjat sanasi')}}</label>
                  <date-picker
                          lang="ru"
                          type="date"
                          v-model="car.pDateNatarius"
                          valueType="format"
                          class="input_style"
                          :class="isRequired(car.pDateNatarius) ? 'isRequired' : ''"
                        ></date-picker>
                </div>
                <div class="form-group col-md-6">
                  <label for="pTexpassportSery">{{$t('Texpasport seriyasi')}} </label>
                  <input
                    type="text"
                    class="form-control input_style"
                    id="pTexpassportSery"
                    v-model="car.pTexpassportSery"
                    :class="isRequired(car.pTexpassportSery) ? 'isRequired' : ''"
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="pTexpassportNumber">{{$t('Texpasport raqami')}}</label>
                  <input
                    type="number"
                    class="form-control input_style"
                    id="pTexpassportNumber"
                    v-model="car.pTexpassportNumber"
                    :class="isRequired(car.pTexpassportNumber) ? 'isRequired' : ''"
                  >
                </div>
              </div>
            </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <i class="fas fa-times"></i>
              {{$t('Yopish')}}
            </button>
            <button type="button" class="btn btn-primary" @click.prevent="addCar">
              <i class="fas fa-save"></i>
              {{$t('Saqlash')}}
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- QRCODE Modal -->
    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body d-flex justify-content-center">
                <div class="qr_code_modal">
                  <h4><b> {{$t('Sizning arizangiz qabul qilinadi')}}!</b></h4>
                  <div>
                    <b>{{$t('Ariza raqami')}} №</b> {{form.id}}
                  </div>
                  <div>
                    <b>{{$t('Tender sanasi')}}:</b> {{form.tender ? $g.getDate(form.tender.time) : ''}}
                  </div>
                  <div>
                    <b>{{$t('Manzil')}}:</b> {{form.tender ? form.tender.address : ''}}
                  </div>
                  <div>
                    <b>{{$t('Tender vaqti')}}:</b> {{form.tender ? $g.getTime(form.tender.time) : ''}}
                  </div>
                  <img :src="'/'+form.qr_code" alt="">
                </div>
                </div>
              </div>
          </div>
        </div>

        <!-- Offer -->

        <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="offerTitle" aria-hidden="true">
      <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="offerTitle">{{$t('Kelishuv')}}</h5>
            <button type="button" class="close" @click.prevent="closeOfferModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </div>
          <div class="modal-footer">
            <div class="form-group d-flex justify-content-end align-items-center offer_btn">
              <input type="checkbox" name="" true-value="1" id="offer" false-value="0" v-model="offer">
              <label for="offer" class="form-control-label ml-2 mt-3 text-info">
                <h5>{{$t('Tanishib chiqdim va roziman')}}</h5>
              </label>
            </div>
            <button type="button" class="btn btn-info" @click.prevent="offerConfirm">
              <i class="fas fa-share-square"></i>
              {{$t('Yuvorish')}}
            </button>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>
<script>
  import DatePicker from "vue2-datepicker";
  import { mapGetters , mapActions } from 'vuex'
    import Multiselect from 'vue-multiselect';
    import Loader from '../../Loader'
  export default{
    components:{
      Multiselect,
            DatePicker,
            Loader
    },
    data(){
      return{
                laoding: true,
        form:{
          direction_ids:[],
          tarif:[],
          qty_reys:[],
          direction_id:'',
          daily_medical_job:0,
          daily_technical_job:0,
          videoregistrator:0,
          gps:0,
                    hours_rule:0,
        },
        car:{
                    app_id: null,
          bustype_id:'',
          busmarka_id:'',
          direction_id:'',
          busmodel_id:'',
          tclass_id:'',
          capacity:'',
          seat_qty:'',
          date:'',
          conditioner:0,
          internet:0,
          bio_toilet:0,
          bus_adapted:0,
          telephone_power:0,
          monitor:0,
          station_announce:0,
          owner_type:'owner',
          pNumberNatarius:'',
          pDateNatarius:'',
          pTexpassportSery:'',
            pTexpassportNumber:'',
            auto_number:'',
        },
        tclasses:[],
        bus_marks:[],
        bus_models:[],
        file:'',
        files:[],
        cars_with:[],
        findList:[],
        direction_ids:[],
        lots:[],
        requiredInput:false,
        showBtn:Number,
        isLoading:false,
        newItems:[],
        requiredDataInput:false,
        showDirections:false,
                makeDisabled:false,
                contract_time:'',
                old_contract_time:'',
                timeOptions: [
                    {name: '1 yil', val: 1},
                    {name: '2 yil', val: 2},
                    {name: '3 yil', val: 3},
                    {name: '4 yil', val: 4},
                    {name: '5 yil', val: 5},
                ],
                offer:0
      }
    },
    computed:{
      ...mapGetters('direction',['getDirectionFindList']),
      ...mapGetters('application',[
        'getMassage',
        'getUserShowApp',
        'getGaiVehicle',
        'getAdliya',
        'getActivate',
      ]),
      ...mapGetters('typeofbus',['getTypeofbusList']),
            ...mapGetters('busmodel',['getBusmodelList', 'getBusmodelFindList']),
      ...mapGetters('busclass',['getBusclassFindList']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
        checkCars(){
          this.form.cars.forEach((item,index)=>{
            if (item.auto_number != '' && item.bustype_id != '' && item.busmodel_id != '' && item.tclass_id != '') {
              return true
            }else{
              return false
            }
          })
        },
        countCapacity(){
          let count = 0
          this.cars_with.forEach((car,index)=>{
            count +=Number(car.capacity)
          })
          return count
        } ,
        countSeatQty(){
        let count = 0
          this.cars_with.forEach((car,index)=>{
            count +=Number(car.seat_qty)
          })
          return count
        },
    },
    watch:{
      getUserShowApp:{
        handler(){
          if (this.getUserShowApp) {
              this.cars_with = this.getUserShowApp.cars_with
            this.files = this.getUserShowApp.attachment
            // this.form = this.getUserShowApp
            // this.direction_ids = this.getUserShowApp.tender.direction_ids
            this.direction_ids = this.getUserShowApp.lots.direction_id
            this.lots = this.getUserShowApp.tender.tenderlots

            if (this.getUserShowApp.qr_code){
                  this.makeDisabled = true
            }else{
                  this.makeDisabled = false
            }
          }
        }
      },
      getBusclassFindList:{
        handler(){
          // this.tclasses = this.getBusclassFindList
          // this.car.tclass_id = this.tclasses.length > 0 ? this.tclasses[0].id : ''
        }
      },
      'car.owner_type':{
        handler(){
          if (this.car.owner_type == 'owner') {
            this.car.pNumberNatarius=''
            this.car.pDateNatarius=''
          }else if(this.car.owner_type == 'rent'){
            // this.car.pTexpassportSery=''
            // this.car.pTexpassportNumber=''
          }
        },deep:true
      },
      'car.auto_number':{
        handler(){
          if (this.car.auto_number.length > 8) {
                this.car.auto_number = this.car.auto_number.slice(0,8)
              }
        },deep:true
      },
    },
    async mounted(){
      $('#offerModal').modal({backdrop: 'static',keyboard: true, show: false});
      await this.actionUserShowApp(this.$route.params.userapplicationId)
      await this.actionTypeofbusList()
      await this.actionBusmodelList()
            await this.actionBusBrandList()
            this.calcTimeContract()
            if(this.getUserShowApp){
              this.laoding = false
              this.form = this.getUserShowApp
        this.cars_with = this.getUserShowApp.cars_with
        this.files = this.getUserShowApp.attachment
        // this.direction_ids = this.getUserShowApp.tender.direction_ids
        this.direction_ids = this.getUserShowApp.lots.direction_id
              this.lots = this.getUserShowApp.tender.tenderlots
              this.car.app_id = this.$route.params.userapplicationId;
                if(this.getUserShowApp.tarif){
                    this.form.tarif = this.getUserShowApp.tarif.length ? this.getUserShowApp.tarif : []
                }else{
                    this.form.tarif  =  []
                }
                if(this.getUserShowApp.qty_reys){
                    this.form.qty_reys = this.getUserShowApp.qty_reys.length ? this.getUserShowApp.qty_reys : []
                }else{
                    this.form.qty_reys  =  []
                }
                if(!this.form.tarif.length){
                    // this.getUserShowApp.tender.direction_ids.forEach((item)=>{
                    //     let tarif_data = {direction_id: item.id, summa: ''};
                    //     let qty_data = {direction_id: item.id, qty: ''};
                    //     this.form.tarif.push(tarif_data)
                    //     this.form.qty_reys.push(qty_data)
                    // })
                    this.getUserShowApp.lots.direction_id.forEach((item)=>{
                        let tarif_data = {direction_id: item.id, summa: ''};
                        let qty_data = {direction_id: item.id, qty: ''};
                        this.form.tarif.push(tarif_data)
                        this.form.qty_reys.push(qty_data)
                    })
                }

            }else{
        this.$router.push('/notfound')
            }
    },
    methods:{
      ...mapActions('application',[
        'actionUserShowApp',
        'actionUpdateApplication',
        'actionAddCar',
        'actionAddFile',
        'actionRemoveFile',
        'actionRemoveCar',
        'actionGaiVehicle',
        'actionAdliya',
        'actionActivate',
      ]),
      ...mapActions('typeofbus',['actionTypeofbusList']),
      ...mapActions('busmodel',['actionBusmodelList', 'actionBusmodelListByBrand', 'actionBusmodelFindList']),
      ...mapActions('direction',['actionDirectionFind']),
      ...mapActions('busclass',['actionBusclassFind']),
            ...mapActions("busbrand",["actionBusBrandList"]),
            async offerConfirm(){
              if(this.offer == 1){
                  this.laoding = true
          await this.actionActivate(this.$route.params.userapplicationId)
          if (this.getActivate.success){
            await this.actionUserShowApp(this.$route.params.userapplicationId)
            await this.openQrcode()
                  }else{
                  toast.fire({
                type: 'error',
                icon: 'error',
              title: this.getActivate.message,
              });
              this.offer = 0
                  }
            this.closeOfferModal()
                  this.laoding = false
              }
              else{
                toast.fire({
                  type: "error",
                  icon: "error",
                  title: "Ознакомьтесь с текстом публичной оферты "
                });
              }
            },
      openQrcode(){
        $('#qrcodeModal').modal('show')
      },
      openOfferModal(){
        $('#offerModal').modal('show')
      },
      closeOfferModal(){
        $('#offerModal').modal('hide')
      },
      getTClassName(id){
        if(this.tclasses.length > 0){
          let name = ''
          this.tclasses.forEach((item,index)=>{
            if(item.id == this.car.tclass_id){
              name = item.name
            }
          })
          return name
        }else{
          return 'Выберите класс авто'
        }
      },
      activate(){
        this.openOfferModal()
      },
      activeEditClass(item){
          if (item.status == 'active'){
            return 'edit-active'
          }else{
            return 'edit-pending'
          }
            },
            checkDate(date){
              let currentYear = new Date().getFullYear()
              if(date >= 1971 && date <= currentYear){
                this.notBeforeYear(date)
              }else{
                this.car.date = ''
              }
            },
            notBeforeYear(date){
              let numberYear = 14;
              if(this.car.bustype_id != 3){
                numberYear = 50;
              }
                let beforeYear = new Date(new Date().getFullYear() - numberYear, 0, 1)
                return  date > new Date() || date < beforeYear
            },
            calcTimeContract(){
                if(this.cars_with.length){
                    let date_time = []
                    this.cars_with.forEach((item)=>{
                        date_time.push(parseInt(item.date))
                    })
                    let calcAvr = date_time.reduce((a,b) => a + b, 0) / date_time.length;
                    let curYear = new Date().getFullYear()
                    let res = curYear  - calcAvr
                    if(res < 2){
                        this.contract_time = 5
                    }else if(res < 5){
                        this.contract_time = 4
                    }else if(res < 8){
                        this.contract_time = 3
                    }else if(res < 11){
                        this.contract_time = 2
                    }else if(res < 14){
                        this.contract_time = 2
                    }else{
                        this.contract_time = ''
                    }
                    this.old_contract_time = this.contract_time;
                }
            },
        changePhoto(event) {
          this.file = event.target.files[0];
          // let file = event.target.files[0];
          // if (
          //   event.target.files[0]["type"] === "image/png" ||
          //   event.target.files[0]["type"] === "image/jpeg" ||
          //   event.target.files[0]["type"] === "image/jpg"
          // ) {
          //   if (file.size > 1048576) {
          //     swal.fire({
          //       type: "error",
          //       title: "Ошибка",
          //       text: "Размер изображения больше лимита"
          //     });
          //   } else {
          //     let reader = new FileReader();
          //     reader.onload = event => {
          //       this.file = event.target.result;
          //     };
          //     reader.readAsDataURL(file);
          //   }
          // } else {
          //   swal.fire({
          //     type: "error",
          //     title: "Ошибка",
          //     text: "Картинка должна быть только png,jpg,jpeg!"
          //   });
          // }
        },
        async addFile(){
          let formData = new FormData();
        formData.append('file', this.file);
                formData.append('app_id', this.$route.params.userapplicationId);
                this.laoding = true
        await this.actionAddFile(formData)
        if(this.getMassage.success){
          toast.fire({
                  type: "success",
                  icon: "success",
                  title: this.getMassage.message
                });
                this.file = ''
          await this.actionUserShowApp(this.$route.params.userapplicationId)
                }
                this.laoding = false
        },
        async removeFile(id){
          if(confirm("Вы действительно хотите удалить?")){
                    this.laoding = true
                    await this.actionRemoveFile(id);
                    this.laoding = false
            if(this.getMassage.success){
            toast.fire({
                    type: "success",
                    icon: "success",
                    title: this.getMassage.message
                  });
            await this.actionUserShowApp(this.$route.params.userapplicationId)
          }
          }
        },
      showTable(index){
                if(this.showBtn == index){
                    this.showBtn = Number
                }else{
                    this.showBtn = index
                }
      },
      defaultValuesOfCar(dir){
        this.car.app_id = this.$route.params.userapplicationId
          this.car.bustype_id = ''
          this.car.direction_id = dir.id
          this.car.tclass_id = ''
          this.car.busmarka_id = ''
          this.car.busmodel_id = ''
          this.car.date = ''
          this.car.capacity = ''
          this.car.seat_qty = ''
          this.car.conditioner = 0
          this.car.internet = 0
          this.car.bio_toilet = 0
          this.car.bus_adapted = 0
          this.car.telephone_power = 0
          this.car.monitor = 0
          this.car.station_announce = 0
          this.car.owner_type='owner'
        this.car.pNumberNatarius=''
        this.car.pDateNatarius=''
        this.car.pTexpassportSery=''
        this.car.pTexpassportNumber=''
        this.car.auto_number=''
          this.requiredInput = false
        },
      isRequiredData(input){
        if(this.requiredDataInput){
          if(input === '' || input === null){
            return true
          }
        }else{
          return false
        }
        },
      isRequired(input){
          return this.requiredInput && input === '';
        },
        openModal(dir){
          $('#myModal').modal('show');
          this.defaultValuesOfCar(dir)
        },
        removeDirectionFromList(data){
          this.direction_ids = {}
          this.findList = []
        },
        dispatchAction(data){
          this.form.direction_ids.push(data.id);
          this.form.direction_id = data.id
        },
        async findDirection(value){
          if(value != ''){
            this.isLoading = true
            await setTimeout(async ()=>{
          await this.actionDirectionFind({name: value})
              this.findList = this.getDirectionFindList
            this.isLoading = false
            },1000)
          }
        },
        async selectBustype(bustype_id){
          this.car.tclass_id = ''
          this.car.busmarka_id = ''
          this.car.busmodel_id = ''
          if(bustype_id){
            let data = {
              'bustype_id':bustype_id,
                    }
                    this.laoding = true
                    await this.actionBusclassFind(data)
                    this.laoding = false
            // this.tclasses = this.getBusclassFindList
          }
        },
        async selectClass(tclass_id){
          this.car.busmarka_id = ''
          this.car.busmodel_id = ''
        },
        async selectFindClass(bustype_id){
                this.car.tclass_id = ''
                if(this.car.bustype_id && this.car.busmarka_id && this.car.busmodel_id){
                    await this.actionBusclassFind(this.car)
                    this.tclasses = this.getBusclassFindList
                }
        },
        async selectMarka(tclass_id){
          this.car.busmarka_id = ''
          this.car.busmodel_id = ''
          this.bus_marks = this.tclasses.filter((item,index)=>{
            if(item.id == tclass_id){
              return item;
            }
          })
        },
        async selectModel(marka_id){
          this.car.busmodel_id = ''
          this.bus_models = this.bus_marks.filter((item,index)=>{
            if (item.marka.id == marka_id){
              return item
            }
          })
        },
        async addCar(){
          if (
            this.car.bustype_id != '' &&
            this.car.tclass_id != '' &&
            this.car.busmarka_id != '' &&
            this.car.busmodel_id != '' &&
            this.car.date != '' &&
            this.car.capacity != '' &&
            this.car.seat_qty != ''
          )
          {
            if (this.car.owner_type == 'owner'){
                        this.car.app_id = this.$route.params.userapplicationId
                        this.laoding = true
                        await this.actionGaiVehicle(this.car)
                        this.laoding = false
            }else if(this.car.owner_type == 'rent'){
              if (this.car.pDateNatarius != '' && this.car.pNumberNatarius != '' && this.car.pTexpassportSery != '' && this.car.pTexpassportNumber != '') {
                let car = {
                  'pDateNatarius':this.car.pDateNatarius,
                  'pNumberNatarius':this.car.pNumberNatarius,
                  'auto_number':this.car.auto_number,
                  'pTexpassportSery':this.car.pTexpassportSery,
                  'pTexpassportNumber':this.car.pTexpassportNumber,
                  'date':this.car.date,
                }
                let data = {
                  'cars':car,
                  'app_id':this.$route.params.userapplicationId,
                }
                await this.actionAdliya(data)
                this.requiredInput = false
              }else{
                this.requiredInput = true
              }
            }
            if (this.getMassage.success){
                        this.car['app_id'] = this.$route.params.userapplicationId
                        this.laoding = true
              await this.actionAddCar(this.car)
              if(this.getMassage.success){
                await this.actionUserShowApp(this.$route.params.userapplicationId)
                toast.fire({
                      type: "success",
                      icon: "success",
                      title: this.getMassage.message
                    });
                              this.calcTimeContract()
                $('#myModal').modal('hide')
              }else{
                toast.fire({
                      type: "success",
                      icon: "success",
                      title: this.getMassage.message
                    });
                        }
                        this.laoding = false
              this.requiredInput = false
            }else{
              toast.fire({
                    type: "error",
                    icon: "error",
                    title: this.getMassage.message
                  });
                  this.requiredInput = true
            }
          }else{
            this.requiredInput = true
          }
        },
        async saveData(){
          let check = true
          if (this.form.hours_rule == 1){
            if (this.files.length > 0) {
              check = true
            }else{
              check = false
            }
          }
                this.requiredDataInput = false
                this.form.tarif.forEach((item)=>{
                    if(item.summa == ''){
                        this.requiredDataInput = true
                    }
                })
                this.form.qty_reys.forEach((item)=>{
                    if(item.qty == ''){
                        this.requiredDataInput = true
                    }
                })
          if(!this.requiredDataInput && this.form.qty_reys != '' && this.form.qty_reys != null){
            if (check) {
                      this.laoding = true
              await this.actionUpdateApplication(this.form)
              if(this.getMassage.success){
                toast.fire({
                      type: "success",
                      icon: "success",
                      title: this.getMassage.message
                    });
                await this.actionUserShowApp(this.$route.params.userapplicationId)
                      }else{
                        toast.fire({
                      type: "error",
                      icon: "error",
                      title: this.getMassage.message
                    });
                      }
                      this.laoding = false
            }else{
              toast.fire({
                    type: "error",
                    icon: "error",
                    title: 'Загрузите файл!'
                  });
            }
            this.requiredDataInput = false
          }else{
            this.requiredDataInput = true
          }
        },
        async deleteCar(id){
          if(confirm("Вы действительно хотите удалить?")){
                    this.laoding = true
            await this.actionRemoveCar(id);
            if(this.getMassage.success){
            toast.fire({
                    type: "success",
                    icon: "success",
                    title: this.getMassage.message
                  });
            await this.actionUserShowApp(this.$route.params.userapplicationId)
                    }else{
                      toast.fire({
                    type: "error",
                    icon: "error",
                    title: this.getMassage.message
                  });
                    }
                    this.laoding = false
          }
        },
        async selectCarMarka(car){
                car.busmodel_id = ''
                // this.car.tclass_id = ''
                this.laoding = true
                // await this.actionBusmodelListByBrand({busbrand_id: this.car.busmarka_id});
                await this.actionBusmodelFindList(car);
                this.laoding = false
                this.bus_models = this.getBusmodelList
            },
    }
  }
</script>
<style scoped>
  .btn_show{
      display: flex;
      align-items: center;
      margin-top: 30px;
  }
  .btn_save{
      display: flex;
      align-items: center;
      margin-top: 15px;
  }
  .road_price{
      width: 84px;
  }
  .app_title{
    width:75%;
    text-align: center;
  }
  .qr_code{
    font-size: 25px;
      color: black;
      border: 1px solid black;
      margin-right: 30px;
      padding: 0px 9px;
      cursor: pointer;
  }
  .qr_code_modal{
    border: 1px solid black;
      width: 100%;
      padding: 20px;
      text-align:center;
  }
  .offer_btn label,.offer_btn h5, .offer_btn input{
    cursor:pointer;
      font-weight: 600;
  }
</style>
