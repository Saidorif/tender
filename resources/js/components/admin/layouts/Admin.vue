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
        <a href="#" class="logout_btn" @click.prevent="logoutProfile"> <i class="pe-7s-next-2"></i> Выйти</a>
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
          <li class="nav-item">
             <!-- v-if="$can('profile', 'UserController')" -->
            <router-link to="/crm/dashboard" class="nav-link">
              <span class="peIcon pe-7s-rocket" style="font-size: 20px;"></span>
              <p>
                Админ панель
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/profile">
              <i class="peIcon pe-7s-user"></i>
              <p>
                Мои данные
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/apply">
              <i class="peIcon fas fa-vote-yea"></i>
              <p>
                Доступ
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/client">
              <i class="peIcon pe-7s-users"></i>
              <p>
                Перевозчики
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/direction">
              <i class="peIcon fas fa-route"></i>
              <p>
                Направления
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/tenderannounce">
              <i class="peIcon fas fa-bullhorn"></i>
              <p>
                Объявить тендер
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/tenderuser">
              <i class="peIcon fas fa-file"></i>
              <p>
                Тендеры
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon fas fa-file" style="font-size: 20px;"></span>
              <p>
                Итоги тендеров
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/completed-tenders">
                  <p>
                    Завершенные тендеры
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/check-control">
                  <p>
                    Проверка тендеры
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/protocol-list">
                  <p>
                    Протокол
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/contract">
                  <p>
                    Договора
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/confirm-tender">
              <i class="peIcon fas fa-clipboard-check"></i>
              <p>
                Подтвердить тендер
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/position">
              <i class="peIcon pe-7s-graph1"></i>
              <p>
                Должность
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/application">
              <i class="peIcon fas fa-file"></i>
              <p>
                Заявки
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/payment">
              <i class="peIcon fas fa-money-bill-alt"></i>
              <p>
                Платежи
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/employee">
              <i class="peIcon fas fa-users"></i>
              <p>
                Сотрудники
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon fas fa-comment" style="font-size: 20px;"></span>
              <p>
                Обращения
                <span class="badge badge-primary" v-if="getComplaintLength">{{getComplaintLength}}2</span>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/complaint-list">
                  <p>
                    Список обращения
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/complaint">
                  <p>
                    Вариант обращения
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="peIcon fas fa-cogs" style="font-size: 20px;"></i>
              <p>
                Основные настройки
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/region">
                  <i class="peIcon fas fa-globe"></i>
                  <p>
                    Области
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/area">
                  <i class="peIcon fas fa-globe-europe"></i>
                  <p>
                    Регион / Город
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/station">
                  <i class="peIcon fas fa-bus"></i>
                  <p>
                    Автостанция
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/typeofdirection">
                  <i class="peIcon fas fa-border-style"></i>
                  <p>
                    Тип направления
                  </p>
                </router-link>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link" >
                  <i class="peIcon fas fa-bus"></i>
                  <p>
                    Автобуса
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/crm/typeofbus">
                            <p>
                                Тип автобуса
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/crm/busclass">
                            <p>
                                Класс автобуса
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/crm/busbrand">
                        <p>
                            Марка автобуса
                        </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/crm/busmodel">
                        <p>
                            Модель автобуса
                        </p>
                        </router-link>
                    </li>
                </ul>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/conditionalsign">
                  <i class="peIcon fas fa-sign"></i>
                  <p>
                    Условные символы
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-settings" style="font-size: 20px;"></span>
              <p>
                Setting users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/role">
                  <p>
                    Role
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/conts">
                  <p>
                    Controller
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
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
    <strong>Copyright &copy; 2020 <a href="#">MIRXAN </a>.</strong>
    All rights reserved.
  </footer>
</div>
</div>
</template>

<script>
  import { mapActions, mapGetters } from "vuex";
  import {TokenService} from './../../../services/storage.service'
export default {
  components: {
  },
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
</style>
