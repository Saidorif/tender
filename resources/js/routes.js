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
import sendApply from './components/auth/sendApply'
import Register from './components/auth/register'
import Forgot from './components/auth/forgot'
import Profile from './components/admin/user/Profile'

// Employee
import TenderApplication from './components/admin/application/TenderApplication'
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

// UserDirection
import UserDirection from './components/admin/userdirection/UserDirection'



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

// Tarifcity
import Tarifcity from './components/admin/tarifcity/Tarifcity'
import AddTarifcity from './components/admin/tarifcity/AddTarifcity'
import EditTarifcity from './components/admin/tarifcity/EditTarifcity'

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

import UserComplaint from './components/admin/complaintuser/UserComplaint'
import UserShowComplaint from './components/admin/complaintuser/UserShowComplaint'
import UserAddComplaint from './components/admin/complaintuser/UserAddComplaint'

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

// ShowTenderDetails
import ShowTenderDetails from './components/pages/ShowTenderDetails'

// ConfirmTender
import ConfirmTender from './components/admin/confirmtender/ConfirmTender'
import AddConfirmTender from './components/admin/confirmtender/AddConfirmTender'
import EditConfirmTender from './components/admin/confirmtender/EditConfirmTender'

// ConfirmTiming
import ConfirmTiming from './components/admin/confirmtiming/ConfirmTiming'
import AddConfirmTiming from './components/admin/confirmtiming/AddConfirmTiming'
import EditConfirmTiming from './components/admin/confirmtiming/EditConfirmTiming'

// ConfirmTarif
import ConfirmTarif from './components/admin/confirmtarif/ConfirmTarif'
import AddConfirmTarif from './components/admin/confirmtarif/AddConfirmTarif'
import EditConfirmTarif from './components/admin/confirmtarif/EditConfirmTarif'

// ConfirmScheme
import ConfirmScheme from './components/admin/confirmscheme/ConfirmScheme'
import AddConfirmScheme from './components/admin/confirmscheme/AddConfirmScheme'
import EditConfirmScheme from './components/admin/confirmscheme/EditConfirmScheme'

// ConfirmSchedule
import ConfirmSchedule from './components/admin/confirmschedule/ConfirmSchedule'
import AddConfirmSchedule from './components/admin/confirmschedule/AddConfirmSchedule'
import EditConfirmSchedule from './components/admin/confirmschedule/EditConfirmSchedule'

// ConfirmTitul
import ConfirmTitul from './components/admin/confirmtitul/ConfirmTitul'
import AddConfirmTitul from './components/admin/confirmtitul/AddConfirmTitul'
import EditConfirmTitul from './components/admin/confirmtitul/EditConfirmTitul'

// CompletedTenders
import CompletedTenders from './components/admin/completedtenders/CompletedTenders'
import AddCompletedTenders from './components/admin/completedtenders/AddCompletedTenders'
import EditCompletedTenders from './components/admin/completedtenders/EditCompletedTenders'
// UserCompletedTenders
import UserCompletedTenders from './components/admin/usercompletedtenders/UserCompletedTenders'

// Protocol
import Protocol from './components/admin/protocol/Protocol'
import ProtocolList from './components/admin/protocol/ProtocolList'

// apply
import Apply from './components/admin/apply/Apply'

// CheckControl
import CheckControl from './components/admin/checkcontrol/CheckControl'
import AddCheckControl from './components/admin/checkcontrol/AddCheckControl'
import EditCheckControl from './components/admin/checkcontrol/EditCheckControl'

// CheckAuto
import CheckAuto from './components/admin/checkauto/CheckAuto'
import AddCheckAuto from './components/admin/checkauto/AddCheckAuto'
import EditCheckAuto from './components/admin/checkauto/EditCheckAuto'

// Home
import Home from './components/pages/Home'
import Contact from './components/pages/Contact'
import About from './components/pages/About'
import CheckContract from './components/pages/CheckContract'
import TenderList from './components/pages/TenderList'
import TenderListCompleted from './components/pages/TenderListCompleted'
import Searchtarif from './components/pages/Searchtarif'

// TenderUser
import TenderUser from './components/admin/tenderuser/TenderUser'
import EditTenderUser from './components/admin/tenderuser/EditTenderUser'
import SendApplication from './components/admin/tenderuser/SendApplication'
// import Contract from './components/admin/tenderuser/Contract'

import Contract from './components/admin/contract/Contract'
import ContractList from './components/admin/contract/ContractList'


// Payment
import Payment from './components/admin/payment/Payment'
import EditPayment from './components/admin/payment/EditPayment'
import AddPayment from './components/admin/payment/AddPayment'

// Setting
import Setting from './components/admin/setting/Setting'

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
					meta:{
						action:'index',
						subject:'DashboardController'
					}
				},
				{
					path:'profile',
					component:Profile,
					meta:{
						action:'profile',
						subject:'UserController'
					}
				},
				{
					path:'tender/application',
					component:TenderApplication,
					meta:{
						action:'index',
						subject:'ApplicationController'
					}
				},
				{
					path:'application/:tenderAppId',
					component:Application,
					meta:{
						action:'show',
						subject:'ApplicationController'
					}
				},
				{
					path:'application/add',
					component:AddApplication,
					meta:{
						action:'store',
						subject:'ApplicationController'
					}
				},
				{
					path:'application/edit/:applicationId',
					component:EditApplication,
					meta:{
						action:'edit',
						subject:'ApplicationController'
					}
				},
				{
					path:'employee',
					component:Employee,
					meta:{
						action:'index',
						subject:'EmployeeController'
					}
				},
				{
					path:'employee/add',
					component:AddEmployee,
					meta:{
						action:'store',
						subject:'EmployeeController'
					}
				},
				{
					path:'employee/edit/:employeeId',
					component:EditEmployee,
					meta:{
						action:'edit',
						subject:'EmployeeController'
					}
				},
				{
					path:'client',
					component:Client,
					meta:{
						action:'carrier',
						subject:'UserController'
					}
				},
				{
					path:'client/add',
					component:AddClient,
				},
				{
					path:'client/edit/:clientId',
					component:EditClient,
					meta:{
						action:'carrierEdit',
						subject:'UserController'
					}
				},
				{
					path:'role',
					component:Role,
					meta:{
						action:'index',
						subject:'RoleController'
					}
				},
				{
					path:'role/add',
					component:AddRole,
					meta:{
						action:'store',
						subject:'RoleController'
					}
				},
				{
					path:'role/edit/:roleId',
					component:EditRole,
					meta:{
						action:'edit',
						subject:'RoleController'
					}
				},
				{
					path:'role/:roleId',
					component:Permission,
					meta:{
						action:'index',
						subject:'PermissionController'
					}
				},
				{
					path:'position',
					component:Position,
					meta:{
						action:'index',
						subject:'PositionController'
					}
				},
				{
					path:'position/add',
					component:AddPosition,
					meta:{
						action:'store',
						subject:'PositionController'
					}
				},
				{
					path:'position/edit/:positionId',
					component:EditPosition,
					meta:{
						action:'edit',
						subject:'PositionController'
					}
				},
				{
					path:'conts',
					component:Conts,
					meta:{
						action:'index',
						subject:'ContsController'
					}
				},
				{
					path:'conts/add',
					component:AddConts,
					meta:{
						action:'store',
						subject:'ContsController'
					}
				},
				{
					path:'conts/edit/:contId',
					component:EditConts,
					meta:{
						action:'edit',
						subject:'ContsController'
					}
				},
				{
					path:'action',
					component:Action,
					meta:{
						action:'index',
						subject:'ActionController'
					}
				},
				{
					path:'action/add',
					component:AddAction,
					meta:{
						action:'store',
						subject:'ActionController'
					}
				},
				{
					path:'action/edit/:actionId',
					component:EditAction,
					meta:{
						action:'edit',
						subject:'ActionController'
					}
				},
				{
					path:'region',
					component:Region,
					meta:{
						action:'index',
						subject:'RegionController'
					}
				},
				{
					path:'region/add',
					component:AddRegion,
					meta:{
						action:'store',
						subject:'RegionController'
					}
				},
				{
					path:'region/edit/:regionId',
					component:EditRegion,
					meta:{
						action:'edit',
						subject:'RegionController'
					}
				},
				{
					path:'area',
					component:Area,
					meta:{
						action:'index',
						subject:'AreaController'
					}
				},
				{
					path:'area/add',
					component:AddArea,
					meta:{
						action:'store',
						subject:'AreaController'
					}
				},
				{
					path:'area/edit/:areaId',
					component:EditArea,
					meta:{
						action:'edit',
						subject:'AreaController'
					}
				},
				{
					path:'tarifcity',
					component:Tarifcity,
					meta:{
						action:'index',
						subject:'TarifCityController'
					}
				},
				{
					path:'tarifcity/add',
					component:AddTarifcity,
					meta:{
						action:'store',
						subject:'TarifCityController'
					}
				},
				{
					path:'tarifcity/edit/:tarifcityId',
					component:EditTarifcity,
					meta:{
						action:'edit',
						subject:'TarifCityController'
					}
				},
				{
					path:'station',
					component:Station,
					meta:{
						action:'index',
						subject:'StationController'
					}
				},
				{
					path:'station/add',
					component:AddStation,
					meta:{
						action:'store',
						subject:'StationController'
					}
				},
				{
					path:'station/edit/:stationId',
					component:EditStation,
					meta:{
						action:'edit',
						subject:'StationController'
					}
				},
				{
					path:'complaint-list',
					component:ComplaintListAll,
					meta:{
						action:'index',
						subject:'ComplaintCategoryController'
					}
				},
				{
					path:'complaint-list/edit/:complaintListAllId',
					component:EditComplaintListAll,
					meta:{
						action:'edit',
						subject:'ComplaintCategoryController'
					}
				},
				{
					path:'complaint-list-user',
					component:UserComplaint,
				},
				{
					path:'complaint-list-user/show/:id',
					component:UserShowComplaint,
				},
				{
					path:'complaint-list-user/add',
					component:UserAddComplaint
				},
				{
					path:'complaint',
					component:Complaint,
					meta:{
						action:'index',
						subject:'ComplaintController'
					}
				},
				{
					path:'complaint/add',
					component:AddComplaint,
					meta:{
						action:'store',
						subject:'ComplaintController'
					}
				},
				{
					path:'complaint/edit/:complaintId',
					component:EditComplaint,
					meta:{
						action:'edit',
						subject:'ComplaintController'
					}
				},
				{
					path:'direction-user',
					component:UserDirection,
				},
				{
					path:'direction',
					component:Direction,
					meta:{
						action:'index',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/add',
					component:AddDirection,
					meta:{
						action:'store',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/edit/:directionId',
					component:EditDirection,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/titul-tab/:directionId',
					component:Titul,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/schedule-tab/:directionId',
					component:Schedule,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/timing-tab/:directionId',
					component:Timing,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/tarif-tab/:directionId',
					component:Tarif,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/scheme-tab/:directionId',
					component:Scheme,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'direction/demand-tab/:directionId',
					component:Demand,
					meta:{
						action:'requirement',
						subject:'DirectionController'
					}
				},
				// *****
				{
					path:'stepuser/titul-tab/:directionId',
					component:UserTitul,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'stepuser/schedule-tab/:directionId',
					component:UserSchedule,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'stepuser/timing-tab/:directionId',
					component:UserTiming,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'stepuser/tarif-tab/:directionId',
					component:UserTarif,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'stepuser/scheme-tab/:directionId',
					component:UserScheme,
					meta:{
						action:'edit',
						subject:'DirectionController'
					}
				},
				{
					path:'stepuser/demand-tab/:directionId',
					component:UserDemand,
					meta:{
						action:'requirement',
						subject:'DirectionController'
					}
				},
				// *****
				{
					path:'typeofdirection',
					component:Typeofdirection,
					meta:{
						action:'index',
						subject:'DirectionTypeController'
					}
				},
				{
					path:'typeofdirection/add',
					component:AddTypeofdirection,
					meta:{
						action:'store',
						subject:'DirectionTypeController'
					}
				},
				{
					path:'typeofdirection/edit/:typeofdirectionId',
					component:EditTypeofdirection,
					meta:{
						action:'edit',
						subject:'DirectionTypeController'
					}
				},
				{
					path:'typeofbus',
					component:Typeofbus,
					meta:{
						action:'index',
						subject:'BusTypeController'
					}
				},
				{
					path:'typeofbus/add',
					component:AddTypeofbus,
					meta:{
						action:'store',
						subject:'BusTypeController'
					}
				},
				{
					path:'typeofbus/edit/:typeofbusId',
					component:EditTypeofbus,
					meta:{
						action:'edit',
						subject:'BusTypeController'
					}
				},
				{
					path:'busclass',
					component:Busclass,
					meta:{
						action:'index',
						subject:'TClassController'
					}
				},
				{
					path:'busclass/add',
					component:AddBusclass,
					meta:{
						action:'store',
						subject:'TClassController'
					}
				},
				{
					path:'busclass/edit/:busclassId',
					component:EditBusclass,
					meta:{
						action:'edit',
						subject:'TClassController'
					}
				},
				{
					path:'busmodel',
					component:BusModel,
					meta:{
						action:'index',
						subject:'BusModelController'
					}
				},
				{
					path:'busmodel/add',
					component:AddBusModel,
					meta:{
						action:'store',
						subject:'BusModelController'
					}
				},
				{
					path:'busmodel/edit/:busmodelId',
					component:EditBusModel,
					meta:{
						action:'edit',
						subject:'BusModelController'
					}
                },
                {
					path:'busbrand',
					component:BusBrand,
					meta:{
						action:'index',
						subject:'BusMarkaController'
					}
                },
                {
					path:'busbrand/add',
					component:AddBusBrand,
					meta:{
						action:'store',
						subject:'BusMarkaController'
					}
				},
				{
					path:'busbrand/edit/:busbrandId',
					component:EditBusBrand,
					meta:{
						action:'edit',
						subject:'BusMarkaController'
					}
                },
				{
					path:'conditionalsign',
					component:ConditionalSign,
					meta:{
						action:'index',
						subject:'ConditionalSignController'
					}
				},
				{
					path:'conditionalsign/add',
					component:AddConditionalSign,
					meta:{
						action:'store',
						subject:'ConditionalSignController'
					}
				},
				{
					path:'conditionalsign/edit/:conditionalsignId',
					component:EditConditionalSign,
					meta:{
						action:'edit',
						subject:'ConditionalSignController'
					}
				},
				{
					path:'tenderannounce',
					component:TenderAnnounce,
					meta:{
						action:'announceTender',
						subject:'TenderController'
					}
				},
				{
					path:'tenderannounce/add',
					component:AddTenderAnnounce,
					meta:{
						action:'store',
						subject:'TenderController'
					}
				},
				{
					path:'tenderannounce/edit/:tenderannounceId',
					component:EditTenderAnnounce,
					meta:{
						action:'edit',
						subject:'TenderController'
					}
				},
				{
					path:'completed-tenders',
					component:CompletedTenders,
					meta:{
						action:'completedTenders',
						subject:'TenderController'
					}
                },
				{
					path:'completed-tenders-user',
					component:UserCompletedTenders,
                },
				{
					path:'check-control',
					component:CheckControl,
					meta:{
						action:'checkTenders',
						subject:'TenderController'
					}
                },
				{
					path:'check-control/show/:appId',
					component:EditCheckControl,
					meta:{
						action:'appCars',
						subject:'TenderController'
					}
                },
				{
					path:'checkauto',
					component:CheckAuto,
					meta:{
						action:'checkTenders',
						subject:'TenderController'
					}
                },
				{
					path:'checkauto/show/:appId',
					component:EditCheckAuto,
					meta:{
						action:'appCars',
						subject:'TenderController'
					}
                },
                {
					path:'completed-tenders/show/:tenderId',
					component:EditCompletedTenders,
					meta:{
						action:'completedTendersLots',
						subject:'TenderController'
					}
				},
				{
					path:'confirm-tender',
					component:ConfirmTender,
					meta:{
						action:'announceTender',
						subject:'TenderController'
					}
				},
				{
					path:'confirm-tender/add',
					component:AddConfirmTender,
					meta:{
						action:'tenderLotApprove',
						subject:'TenderController'
					}
				},
				{
					path:'confirm-tender/edit/:tenderannounceId',
					component:EditConfirmTender,
					meta:{
						action:'tenderLotApprove',
						subject:'TenderController'
					}
				},
				{
					path:'confirm-timing',
					component:ConfirmTiming,
				},
				{
					path:'confirm-timing/add',
					component:AddConfirmTiming,
				},
				{
					path:'confirm-timing/edit/:confirmtimingId',
					component:EditConfirmTiming,
				},
				{
					path:'confirm-tarif',
					component:ConfirmTarif,
					meta:{
						action:'listTarif',
						subject:'DirectionController'
					}
				},
				{
					path:'confirm-tarif/add',
					component:AddConfirmTarif,
				},
				{
					path:'confirm-tarif/edit/:tarifannounceId',
					component:EditConfirmTarif,
				},
				{
					path:'confirm-scheme',
					component:ConfirmScheme,
				},
				{
					path:'confirm-scheme/add',
					component:AddConfirmScheme,
				},
				{
					path:'confirm-scheme/edit/:confirmschemeId',
					component:EditConfirmScheme,
				},
				{
					path:'confirm-schedule',
					component:ConfirmSchedule,
				},
				{
					path:'confirm-schedule/add',
					component:AddConfirmSchedule,
				},
				{
					path:'confirm-schedule/edit/:confirmscheduleId',
					component:EditConfirmSchedule,
				},
				{
					path:'confirm-titul',
					component:ConfirmTitul,
				},
				{
					path:'confirm-titul/add',
					component:AddConfirmTitul,
				},
				{
					path:'confirm-titul/edit/:confirmtitulId',
					component:EditConfirmTitul,
				},
				{
					path:'payment',
					component:Payment,
					meta:{
						action:'index',
						subject:'PaymentController'
					}
				},
				{
					path:'payment/add',
					component:AddPayment,
					meta:{
						action:'store',
						subject:'PaymentController'
					}
				},
				{
					path:'payment/edit/:paymentId',
					component:EditPayment,
					meta:{
						action:'edit',
						subject:'PaymentController'
					}
				},
				{
					path:'tenderuser',
					component:TenderUser,
					meta:{
						action:'index',
						subject:'TenderController'
					}
				},
				{
					path:'tenderuser/edit/:tenderuserId',
					component:EditTenderUser,
					meta:{
						action:'edit',
						subject:'TenderController'
					}
				},
				{
					path:'application/user/:userapplicationId',
					component:SendApplication,
					meta:{
						action:'store',
						subject:'ApplicationController'
					}
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
					path:'contract-list',
					component:ContractList,
				},
				{
					path:'protocol-list',
					component:ProtocolList,
				},
				{
					path:'setting',
					component:Setting,
				},
				{
					path:'apply',
					component:Apply,
					meta:{
						action:'index',
						subject:'ClientAccessController'
					}
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
					path:'/send-apply',
					name:'sendApply',
					components:{
						default:sendApply,
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
					path:'/checkcontract',
					name:'checkcontract',
					components:{
						default:CheckContract,
					},
				},
				{
					path:'/list-tender/active',
					name:'list-tender',
					components:{
						default:TenderList,
					},
				},
				{
					path:'/list-tender/completed',
					name:'list-tender-completed',
					components:{
						default:TenderListCompleted,
					},
				},
				{
					path:'/search_tarif',
					name:'search_tarif',
					components:{
						default:Searchtarif,
					},
				},
				{
					path:'u/show-tender-details/:tenderId',
					component:ShowTenderDetails,
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
    	if (TokenService.getCurrentUser().role.name != 'admin'){
		 	const checkPerm = to.matched.some(route => {
			    return ability.can(route.meta.action, route.meta.subject)
		  	})
		  	if (!checkPerm) {
			    return next('/notfound')
		  	}
    	}
      	next()
    }
  } else {
    next()
  }
})

export default router;
