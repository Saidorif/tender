import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import {TokenService} from './services/storage.service'
import {ability} from "./store/store";
import store from "./store/store";

// Dashboard component
import Dashboard from './components/admin/Dashboard'
import Admin from './components/admin/layouts/Admin'
import Master from './components/layouts/Master'
import Login from './components/auth/login'
import Register from './components/auth/register'
import Forgot from './components/auth/forgot'
import Profile from './components/admin/user/Profile'

// Employee
import Application from './components/admin/application/Application'
import AddApplication from './components/admin/application/AddApplication'
import EditApplication from './components/admin/application/EditApplication'

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

// Client
import Client from './components/admin/client/Client'
import AddClient from './components/admin/client/AddClient'
import EditClient from './components/admin/client/EditClient'

// BusModel
import BusModel from './components/admin/busmodel/BusModel'
import AddBusModel from './components/admin/busmodel/AddBusModel'
import EditBusModel from './components/admin/busmodel/EditBusModel'

// BusBrand
import BusBrand from './components/admin/busbrand/BusBrand'
import AddBusBrand from './components/admin/busbrand/AddBusBrand'
import EditBusBrand from './components/admin/busbrand/EditBusBrand'

// ConditionalSign
import ConditionalSign from './components/admin/conditionalsign/ConditionalSign'
import AddConditionalSign from './components/admin/conditionalsign/AddConditionalSign'
import EditConditionalSign from './components/admin/conditionalsign/EditConditionalSign'

// TenderAnnounce
import TenderAnnounce from './components/admin/tenderannounce/TenderAnnounce'
import AddTenderAnnounce from './components/admin/tenderannounce/AddTenderAnnounce'
import EditTenderAnnounce from './components/admin/tenderannounce/EditTenderAnnounce'

// Complaint
import EditComplaintListAll from './components/admin/complaint/EditComplaintListAll'
import ComplaintListAll from './components/admin/complaint/ComplaintListAll'
import Complaint from './components/admin/complaint/Complaint'
import AddComplaint from './components/admin/complaint/AddComplaint'
import EditComplaint from './components/admin/complaint/EditComplaint'

// PassportTab
import Schedule from './components/admin/steppassport/Schedule'
import Titul from './components/admin/steppassport/Titul'
import Timing from './components/admin/steppassport/Timing'
import Tarif from './components/admin/steppassport/Tarif'
import Scheme from './components/admin/steppassport/Scheme'
import Demand from './components/admin/steppassport/Demand'

// UserTab
import UserSchedule from './components/admin/stepuser/Schedule'
import UserTitul from './components/admin/stepuser/Titul'
import UserTiming from './components/admin/stepuser/Timing'
import UserTarif from './components/admin/stepuser/Tarif'
import UserScheme from './components/admin/stepuser/Scheme'
import UserDemand from './components/admin/stepuser/Demand'


// stepTender
import USchedule from './components/stepTender/Schedule'
import UTitul from './components/stepTender/Titul'
import UTiming from './components/stepTender/Timing'
import UTarif from './components/stepTender/Tarif'
import UScheme from './components/stepTender/Scheme'
import UDemand from './components/stepTender/Demand'

// ConfirmTender
import ConfirmTender from './components/admin/confirmtender/ConfirmTender'
import AddConfirmTender from './components/admin/confirmtender/AddConfirmTender'
import EditConfirmTender from './components/admin/confirmtender/EditConfirmTender'

// CompletedTenders
import CompletedTenders from './components/admin/completedtenders/CompletedTenders'
import AddCompletedTenders from './components/admin/completedtenders/AddCompletedTenders'
import EditCompletedTenders from './components/admin/completedtenders/EditCompletedTenders'

// Protocol

import Protocol from './components/admin/protocol/Protocol'
import ProtocolList from './components/admin/protocol/ProtocolList'

// CheckControl
import CheckControl from './components/admin/checkcontrol/CheckControl'
import AddCheckControl from './components/admin/checkcontrol/AddCheckControl'
import EditCheckControl from './components/admin/checkcontrol/EditCheckControl'

// Home
import Home from './components/pages/Home'
import Contact from './components/pages/Contact'
import About from './components/pages/About'
import TenderList from './components/pages/TenderList'

// TenderUser
import TenderUser from './components/admin/tenderuser/TenderUser'
import EditTenderUser from './components/admin/tenderuser/EditTenderUser'
import SendApplication from './components/admin/tenderuser/SendApplication'
import Contract from './components/admin/tenderuser/Contract'


// Payment
import Payment from './components/admin/payment/Payment'
import EditPayment from './components/admin/payment/EditPayment'
import AddPayment from './components/admin/payment/AddPayment'


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
					path:'application',
					component:Application,
				},
				{
					path:'application/add',
					component:AddApplication,
				},
				{
					path:'application/edit/:applicationId',
					component:EditApplication,
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
					path:'client',
					component:Client,
				},
				{
					path:'client/add',
					component:AddClient,
				},
				{
					path:'client/edit/:clientId',
					component:EditClient,
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
					path:'complaint-list',
					component:ComplaintListAll,
				},
				{
					path:'complaint-list/edit/:complaintListAllId',
					component:EditComplaintListAll,
				},
				{
					path:'complaint',
					component:Complaint,
				},
				{
					path:'complaint/add',
					component:AddComplaint,
				},
				{
					path:'complaint/edit/:complaintId',
					component:EditComplaint,
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
					path:'direction/titul-tab/:directionId',
					component:Titul,
				},
				{
					path:'direction/schedule-tab/:directionId',
					component:Schedule,
				},
				{
					path:'direction/timing-tab/:directionId',
					component:Timing,
				},
				{
					path:'direction/tarif-tab/:directionId',
					component:Tarif,
				},
				{
					path:'direction/scheme-tab/:directionId',
					component:Scheme,
				},
				{
					path:'direction/demand-tab/:directionId',
					component:Demand,
				},
				// *****
				{
					path:'stepuser/titul-tab/:directionId',
					component:UserTitul,
				},
				{
					path:'stepuser/schedule-tab/:directionId',
					component:UserSchedule,
				},
				{
					path:'stepuser/timing-tab/:directionId',
					component:UserTiming,
				},
				{
					path:'stepuser/tarif-tab/:directionId',
					component:UserTarif,
				},
				{
					path:'stepuser/scheme-tab/:directionId',
					component:UserScheme,
				},
				{
					path:'stepuser/demand-tab/:directionId',
					component:UserDemand,
				},
				// *****
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
				{
					path:'busmodel',
					component:BusModel,
				},
				{
					path:'busmodel/add',
					component:AddBusModel,
				},
				{
					path:'busmodel/edit/:busmodelId',
					component:EditBusModel,
                },
                {
					path:'busbrand',
					component:BusBrand,
                },
                {
					path:'busbrand/add',
					component:AddBusBrand,
				},
				{
					path:'busbrand/edit/:busbrandId',
					component:EditBusBrand,
                },
				{
					path:'conditionalsign',
					component:ConditionalSign,
				},
				{
					path:'conditionalsign/add',
					component:AddConditionalSign,
				},
				{
					path:'conditionalsign/edit/:conditionalsignId',
					component:EditConditionalSign,
				},
				{
					path:'tenderannounce',
					component:TenderAnnounce,
				},
				{
					path:'tenderannounce/add',
					component:AddTenderAnnounce,
				},
				{
					path:'tenderannounce/edit/:tenderannounceId',
					component:EditTenderAnnounce,
				},
				{
					path:'completed-tenders',
					component:CompletedTenders,
                },
				{
					path:'check-control',
					component:CheckControl,
                },
				{
					path:'check-control/show/:appId',
					component:EditCheckControl,
                },
                {
					path:'completed-tenders/show/:tenderId',
					component:EditCompletedTenders,
				},
				{
					path:'confirm-tender',
					component:ConfirmTender,
				},
				{
					path:'confirm-tender/add',
					component:AddConfirmTender,
				},
				{
					path:'confirm-tender/edit/:tenderannounceId',
					component:EditConfirmTender,
				},
				{
					path:'payment',
					component:Payment,
				},
				{
					path:'payment/add',
					component:AddPayment,
				},
				{
					path:'payment/edit/:paymentId',
					component:EditPayment,
				},
				{
					path:'tenderuser',
					component:TenderUser,
				},
				{
					path:'tenderuser/edit/:tenderuserId',
					component:EditTenderUser,
				},
				{
					path:'application/user/:userapplicationId',
					component:SendApplication,
				},
				{
					path:'protocol/:tenderId',
					component:Protocol,
				},
				{
					path:'contract/:conId',
					component:Contract,
				},
				{
					path:'protocol-list',
					component:ProtocolList,
				},
			]
		},
		{
			path:'/',
			name:'master',
			components:{
				default:Master,
			},
			children:[
				{
					path:'/',
					name:'home',
					components:{
						default:Home,
					},
				},
				{
					path:'/login',
					name:'login',
					components:{
						default:Login,
					},
				},
				{
					path:'/register',
					name:'register',
					components:{
						default:Register,
					},
				},
				{
					path:'/forgot',
					name:'forgot',
					components:{
						default:Forgot,
					},
				},
				{
					path:'/contact',
					name:'contact',
					components:{
						default:Contact,
					},
				},
				{
					path:'/about',
					name:'about',
					components:{
						default:About,
					},
				},
				{
					path:'/list-tender',
					name:'list-tender',
					components:{
						default:TenderList,
					},
				},
				{
					path:'u/titul-tab/:directionId',
					component:UTitul,
				},
				{
					path:'u/schedule-tab/:directionId',
					component:USchedule,
				},
				{
					path:'u/timing-tab/:directionId',
					component:UTiming,
				},
				{
					path:'u/tarif-tab/:directionId',
					component:UTarif,
				},
				{
					path:'u/scheme-tab/:directionId',
					component:UScheme,
				},
				{
					path:'u/demand-tab/:directionId',
					component:UDemand,
				},
			]
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
