// Dashboard 
import BulletinForm from './components/administrator/dashboard/BulettinFormComponent.vue'
import EmployeeWidget from './components/administrator/dashboard/EmployeeWidgetComponent.vue'
import LeaveApplication from './components/administrator/dashboard/LeaveApplicationComponent.vue'
import DocumentExpiration from './components/administrator/dashboard/DocumentationExpiration.vue'
import SickLeave from './components/administrator/dashboard/SickLeaveComponent.vue'

Vue.component('bulletin-form', BulletinForm)
Vue.component('employee-widget', EmployeeWidget)
Vue.component('leave-application', LeaveApplication)
Vue.component('document-expiration-widget', DocumentExpiration)
Vue.component('sick-leave', SickLeave)