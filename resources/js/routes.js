import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import {TokenService} from './services/storage.service'
import {ability} from "./store/store";
import store from "./store/store";

// Dashboard component
import Dashboard from './components/admin/Dashboard'
import Admin from './components/admin/layouts/Admin'
import Login from './components/auth/Login'
import Profile from './components/admin/user/Profile'

// Employee
import Employee from './components/admin/employee/Employee'
import AddEmployee from './components/admin/employee/AddEmployee'
import EditEmployee from './components/admin/employee/EditEmployee'

// Role
import Role from './components/admin/role/Role'
import AddRole from './components/admin/role/AddRole'
import EditRole from './components/admin/role/EditRole'
import Permission from './components/admin/permission/Permission'

// Position
import Position from './components/admin/position/Position'
import AddPosition from './components/admin/position/AddPosition'
import EditPosition from './components/admin/position/EditPosition'

// controller
import Conts from './components/admin/conts/Conts'
import AddConts from './components/admin/conts/AddConts'
import EditConts from './components/admin/conts/EditConts'

// controller
import Action from './components/admin/action/Action'
import AddAction from './components/admin/action/AddAction'
import EditAction from './components/admin/action/EditAction'

// Region
import Region from './components/admin/region/Region'
import AddRegion from './components/admin/region/AddRegion'
import EditRegion from './components/admin/region/EditRegion'

// Direction
import Direction from './components/admin/direction/Direction'
import AddDirection from './components/admin/direction/AddDirection'
import EditDirection from './components/admin/direction/EditDirection'

// Type of Direction
import Typeofdirection from './components/admin/typeofdirection/Typeofdirection'
import AddTypeofdirection from './components/admin/typeofdirection/AddTypeofdirection'
import EditTypeofdirection from './components/admin/typeofdirection/EditTypeofdirection'

// Type of Direction
import Typeofbus from './components/admin/typeofbus/Typeofbus'
import AddTypeofbus from './components/admin/typeofbus/AddTypeofbus'
import EditTypeofbus from './components/admin/typeofbus/EditTypeofbus'

// Area
import Area from './components/admin/area/Area'
import AddArea from './components/admin/area/AddArea'
import EditArea from './components/admin/area/EditArea'

// Busclass
import Busclass from './components/admin/busclass/Busclass'
import AddBusclass from './components/admin/busclass/AddBusclass'
import EditBusclass from './components/admin/busclass/EditBusclass'

// Station
import Station from './components/admin/station/Station'
import AddStation from './components/admin/station/AddStation'
import EditStation from './components/admin/station/EditStation'


// NotFound
import NotFound from './components/NotFound/NotFound'
const router = new Router({
	mode: 'history', 
	base: process.env.BASE_URL,
	linkActiveClass: 'active',
	routes: [
		// public components 
		{
			path:'/crm',
			name:'crm',
			redirect:'/crm/dashboard',
			meta:{
				requiredAuth:true
			},
			component:Admin,
			children:[
				{
					path:'dashboard',
					component:Dashboard,
					// meta:{
					// 	action:'index',
					// 	subject:'IndexController'
					// }
				},
				{
					path:'profile',
					component:Profile,
				},
				{
					path:'employee',
					component:Employee,
				},
				{
					path:'employee/add',
					component:AddEmployee,
				},
				{
					path:'employee/edit/:employeeId',
					component:EditEmployee,
				},
				{
					path:'role',
					component:Role,
				},
				{
					path:'role/add',
					component:AddRole,
				},
				{
					path:'role/edit/:roleId',
					component:EditRole,
				},
				{
					path:'role/:roleId',
					component:Permission,
				},
				{
					path:'position',
					component:Position,
				},
				{
					path:'position/add',
					component:AddPosition,
				},
				{
					path:'position/edit/:positionId',
					component:EditPosition,
				},
				{
					path:'conts',
					component:Conts,
				},
				{
					path:'conts/add',
					component:AddConts,
				},
				{
					path:'conts/edit/:contId',
					component:EditConts,
				},
				{
					path:'action',
					component:Action,
				},
				{
					path:'action/add',
					component:AddAction,
				},
				{
					path:'action/edit/:actionId',
					component:EditAction,
				},
				{
					path:'region',
					component:Region,
				},
				{
					path:'region/add',
					component:AddRegion,
				},
				{
					path:'region/edit/:regionId',
					component:EditRegion,
				},
				{
					path:'area',
					component:Area,
				},
				{
					path:'area/add',
					component:AddArea,
				},
				{
					path:'area/edit/:areaId',
					component:EditArea,
				},
				{
					path:'station',
					component:Station,
				},
				{
					path:'station/add',
					component:AddStation,
				},
				{
					path:'station/edit/:stationId',
					component:EditStation,
				},
				{
					path:'direction',
					component:Direction,
				},
				{
					path:'direction/add',
					component:AddDirection,
				},
				{
					path:'direction/edit/:directionId',
					component:EditDirection,
				},
				{
					path:'typeofdirection',
					component:Typeofdirection,
				},
				{
					path:'typeofdirection/add',
					component:AddTypeofdirection,
				},
				{
					path:'typeofdirection/edit/:typeofdirectionId',
					component:EditTypeofdirection,
				},
				{
					path:'typeofbus',
					component:Typeofbus,
				},
				{
					path:'typeofbus/add',
					component:AddTypeofbus,
				},
				{
					path:'typeofbus/edit/:typeofbusId',
					component:EditTypeofbus,
				},
				{
					path:'busclass',
					component:Busclass,
				},
				{
					path:'busclass/add',
					component:AddBusclass,
				},
				{
					path:'busclass/edit/:busclassId',
					component:EditBusclass,
				},
			]
		},
		{
			path:'/',
			name:'login',
			components:{
				default:Login,
			},
		},
		{
			path:'*',
			name:'notfound',
			components:{
				default:NotFound,
			},
		}
	]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiredAuth)) {
  	const loggedIn = TokenService.getToken();
    if (!loggedIn || loggedIn == 'undefined'){
      next({
        path: '/',
        query: { redirect: to.fullPath }
      })
    } else {
    // 	if (TokenService.getCurrentUser().role.name != 'admin') {
		 	// const checkPerm = to.matched.some(route => {
			 //    return ability.can(route.meta.action, route.meta.subject)
		  // 	})
		  // 	if (!checkPerm) {
			 //    return next('/notfound')
		  // 	}
    // 	}
      	next()
    }
  } else {
    next() 
  }
})

export default router;
