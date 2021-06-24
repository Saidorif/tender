<template>
  <div class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="pe-7s-menu" style="font-size: 30px;line-height: 21px;"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="#" class="logout_btn" @click.prevent="logoutProfile"> <i class="pe-7s-next-2"></i>{{$t('Chiqish')}}</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">
    <!-- Brand Logo -->
    <router-link class="brand-link" to="/crm">
      <span class="brand-text font-weight-light">
        e-TENDER
      </span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu treeview" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item" v-if="$can('index', 'DashboardController')">
            <router-link to="/crm/dashboard" class="nav-link">
              <span class="peIcon pe-7s-rocket" style="font-size: 20px;"></span>
              <p>
                {{$t('admin_menu.admin_panel')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('profile', 'UserController')">
            <router-link class="nav-link" to="/crm/profile">
              <i class="peIcon pe-7s-user"></i>
              <p>
               {{$t('admin_menu.my_info')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'ClientAccessController')">
            <router-link class="nav-link" to="/crm/apply">
              <i class="peIcon fas fa-vote-yea"></i>
              <p>
                {{$t('Ruxsat')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('carrier', 'UserController')">
            <router-link class="nav-link" to="/crm/client">
              <i class="peIcon pe-7s-users"></i>
              <p>
                {{$t('Tashuvchilar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/myappeal">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('My arizalarim')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/appeal">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Arizalar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'DirectionController')">
            <router-link class="nav-link" to="/crm/direction">
              <i class="peIcon fas fa-route"></i>
              <p>
                {{$t('Yoʼnalish')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('userIndex', 'DirectionController')">
            <router-link class="nav-link" to="/crm/direction-user">
              <i class="peIcon fas fa-route"></i>
              <p>
                {{$t('Yoʼnalish')}} <small style="padding:2px 6px;background: #74b303;border-radius:3px;">user</small>
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treevie" v-if="$can('listTarifApprove', 'DirectionController')">
            <a href="#" class="nav-link" >
              <i class="peIcon fas fa-clipboard-check"></i>
              <p>
                 {{$t('Tasdiqlash')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treevie">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/confirm-titul">
                  <p>
                    {{$t('Titul')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/confirm-timing">
                  <p>
                     {{$t('Xronametraj')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/confirm-scheme">
                  <p>
                    {{$t('Sxema')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/confirm-schedule">
                  <p>
                    {{$t('Xarkatlanish jadvali')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('listTarifApprove', 'DirectionController')">
                <router-link class="nav-link" to="/crm/confirm-tarif">
                  <p>
                    {{$t('Reyslar soni')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('listTarifApprove', 'DirectionController')">
                <router-link class="nav-link" to="/crm/confirm-confirmdemand">
                  <p>
                    {{$t('Talab')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('announceTender', 'TenderController')">
                <router-link class="nav-link" to="/crm/confirm-tender">
                  <p>
                    {{$t('Tender')}}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item" v-if="$can('announceTender', 'TenderController')">
            <router-link class="nav-link" to="/crm/tenderannounce">
              <i class="peIcon fas fa-bullhorn"></i>
              <p>
                {{$t('Tender eʼlon qilish')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'TenderController')">
            <router-link class="nav-link" to="/crm/tenderuser">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Faol tenderlar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treevie" v-if="$can('completedTenders', 'TenderController')">
            <a href="#" class="nav-link">
              <span class="peIcon fas fa-file" style="font-size: 20px;"></span>
              <p>
                {{$t('Tender natijalari')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treevie">
              <li class="nav-item" v-if="$can('completedTenders', 'TenderController')">
                <router-link class="nav-link" to="/crm/completed-tenders">
                  <p>
                    {{$t('Yakunlangan tenderlar')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('checkTenders', 'TenderController')">
                <router-link class="nav-link" to="/crm/check-control">
                  <p>
                    {{$t('Tenderlarni tekshirish')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('checkTenders', 'TenderController')">
                <router-link class="nav-link" to="/crm/protocol-list">
                  <p>
                    {{$t('Protokol')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('checkTenders', 'TenderController')">
                <router-link class="nav-link" to="/crm/contract-list">
                  <p>
                   {{$t('Shartnomalar')}}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item" v-if="$can('completedTenders', 'TenderController')">
            <router-link class="nav-link" to="/crm/completed-tenders-user">
              <p>
                 {{$t('Yakunlangan tenderlar')}}
                 <small style="padding:2px 6px;background: #74b303;border-radius:3px;">user</small>
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'PositionController')">
            <router-link class="nav-link" to="/crm/position">
              <i class="peIcon pe-7s-graph1"></i>
              <p>
                {{$t('Lavozimi')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('userCertificates', 'ApplicationController')">
            <router-link class="nav-link" to="/crm/certificate">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Svidetelstvo')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/usercertificate">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('moi svidetelstva')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'ApplicationController')">
            <router-link class="nav-link" to="/crm/tender/application">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Arizalar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('userIndex', 'ApplicationController')">
            <router-link class="nav-link" to="/crm/user/application">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Mening arizalarim')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'PaymentController')">
            <router-link class="nav-link" to="/crm/payment">
              <i class="peIcon fas fa-money-bill-alt"></i>
              <p>
                {{$t('admin_menu.payments')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'ProtocolController')">
            <router-link class="nav-link" to="/crm/oldprotocol">
              <i class="peIcon fas fa-file"></i>
              <p>
                {{$t('Eski protokollar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'ContractController')">
            <router-link class="nav-link" to="/crm/oldcontract">
              <i class="peIcon fas fa-file-alt"></i>
              <p>
                {{$t('Eski shartnomalar')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('userIndex', 'ContractController')">
            <router-link class="nav-link" to="/crm/mycontract">
              <i class="peIcon fas fa-file-alt"></i>
              <p>
                {{$t('Mening shartnomalarim')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/setting"  v-if="$can('index', 'SettingController')">
              <i class="peIcon fas fa-cog"></i>
              <p>
                {{$t('Tizimni sozlash')}}
              </p>
            </router-link>
          </li>
          <li class="nav-item" v-if="$can('index', 'EmployeeController')">
            <router-link class="nav-link" to="/crm/employee">
              <i class="peIcon fas fa-users"></i>
              <p>
                {{$t('Xodimlar')}}
              </p>
            </router-link>
          </li>
          <!-- <li class="nav-item" v-if="$can('index', 'EmployeeController')">
            <router-link class="nav-link" to="/crm/complaint-list-user">
              <i class="peIcon fas fa-comment"></i>
              <p>
                Обращения <small style="padding:2px 6px;background: #74b303;border-radius:3px;">user</small>
              </p>
            </router-link>
          </li> -->
          <li class="nav-item has-treevie" v-if="$can('index', 'ComplaintCategoryController')">
            <a href="#" class="nav-link">
              <span class="peIcon fas fa-comment" style="font-size: 20px;"></span>
              <p>
                {{$t('Murojaatlar')}}
                <span class="badge badge-primary" v-if="getComplaintLength">{{getComplaintLength}}</span>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treevie">
              <li class="nav-item" v-if="$can('index', 'ComplaintCategoryController')">
                <router-link class="nav-link" to="/crm/complaint-list">
                  <p>
                    {{$t('Murojaatlar roʼyxati')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'ComplaintController')">
                <router-link class="nav-link" to="/crm/complaint">
                  <p>
                    {{$t('Murojaat turi')}}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treevie" v-if="$can('index', 'AllSettingController')">
            <a href="#" class="nav-link">
              <i class="peIcon fas fa-cogs" style="font-size: 20px;"></i>
              <p>
                {{$t('Asosiy sozlamalar')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treevie">
              <li class="nav-item" v-if="$can('index', 'RegionController')">
                <router-link class="nav-link" to="/crm/region">
                  <i class="peIcon fas fa-globe"></i>
                  <p>
                    {{$t('Viloyatlar')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'AreaController')">
                <router-link class="nav-link" to="/crm/area">
                  <i class="peIcon fas fa-globe-europe"></i>
                  <p>
                    {{$t('Tuman/Shahar')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'StationController')">
                <router-link class="nav-link" to="/crm/station">
                  <i class="peIcon fas fa-bus"></i>
                  <p>
                    {{$t('Avtostansiya')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'DirectionTypeController')">
                <router-link class="nav-link" to="/crm/typeofdirection">
                  <i class="peIcon fas fa-border-style"></i>
                  <p>
                     {{$t('Yoʼnalish turi')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'TarifCityController')">
                <router-link class="nav-link" to="/crm/tarifcity">
                  <i class="peIcon fas fa-border-style"></i>
                  <p>
                    {{$t('Tarif ShY')}}
                  </p>
                </router-link>
              </li>
              <li class="nav-item has-treevie" v-if="$can('index', 'BusTypeController')">
                <a href="#" class="nav-link" >
                  <i class="peIcon fas fa-bus"></i>
                  <p>
                    {{$t('Avtobus')}}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treevie">
                    <li class="nav-item" v-if="$can('index', 'BusTypeController')">
                        <router-link class="nav-link" to="/crm/typeofbus">
                            <p>
                                {{$t('Avtobus turi')}}
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="$can('index', 'TClassController')">
                        <router-link class="nav-link" to="/crm/busclass">
                            <p>
                                {{$t('Avtomobil sinfi')}}
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="$can('index', 'BusMarkaController')">
                        <router-link class="nav-link" to="/crm/busbrand">
                        <p>
                            {{$t('Avtobus markasi')}}
                        </p>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="$can('index', 'BusModelController')">
                        <router-link class="nav-link" to="/crm/busmodel">
                        <p>
                            {{$t('Avtomobil rusumi')}}
                        </p>
                        </router-link>
                    </li>
                </ul>
              </li>
              <li class="nav-item" v-if="$can('index', 'ConditionalSignController')">
                <router-link class="nav-link" to="/crm/conditionalsign">
                  <i class="peIcon fas fa-sign"></i>
                  <p>
                    {{$t('Shartli belgilar')}}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treevie" v-if="$can('index', 'RoleController')">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-settings" style="font-size: 20px;"></span>
              <p>
                Setting users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treevie">
              <li class="nav-item" v-if="$can('index', 'RoleController')">
                <router-link class="nav-link" to="/crm/role">
                  <p>
                    Role
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'ContsController')">
                <router-link class="nav-link" to="/crm/conts">
                  <p>
                    Controller
                  </p>
                </router-link>
              </li>
              <li class="nav-item" v-if="$can('index', 'ActionController')">
                <router-link class="nav-link" to="/crm/action">
                  <p>
                    Actions
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ new Date().getFullYear() }} <a href="https://mintrans.uz" target="_blank">O'ZBEKISTON RESPUBLIKASI TRANSPORT VAZIRLIGI </a>.</strong>
    All rights reserved.
  </footer>
</div>
</div>
</template>

<script>

  import { mapActions, mapGetters } from "vuex";
  import {TokenService} from './../../../services/storage.service'
export default {
  components: {},
  data(){
    return {

    }
  },
  computed: {
    ...mapGetters(['getUser']),
    ...mapGetters('complaint',['getComplaintLength']),
  },
  async mounted(){
    await this.profileUser()
    await this.actionComplaintLength()
    $('.has-treevie a').on('click', function(e){
        e.preventDefault();
        $(this).parent('.has-treevie').toggleClass('menu-opens')
    })
  },
  methods: {
    ...mapActions(['logout','profileUser']),
    ...mapActions('complaint',['actionComplaintLength']),
    logoutProfile(){
      this.logout();
    },

  }
};
</script>

<style scoped>
    .brand-text img{
        width: 52px;
    }
    .nav-sidebar .nav-treevie{
        display: block;
        padding: 0em 0 0 2rem;
        position: relative;
        max-height: 0;
        overflow: hidden;
        transition: .5s !important;
    }

    .nav-sidebar .nav-treevie::before {
        content: "";
        max-height: 0;
        height: 100%;
        opacity: 1;
        width: 3px;
        background: #52dcbc;
        position: absolute;
        left: 32px;
        top: 0;
        border-radius: 15px;
        transition: .5s !important;
    }
    .nav-sidebar .has-treevie.menu-opens .nav-treevie::before,
    .has-treevie.menu-opens > .nav-treevie{
        max-height: 700px;
    }
    .nav-sidebar .menu-opens>.nav-link i.right{
        transform: rotate(-90deg);
    }
</style>
