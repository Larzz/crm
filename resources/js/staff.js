
import LeaveApplication from './components/staff/LeaveApplicationComponent.vue'
import StaffComponent from './components/staff/StaffComponent.vue'
import DocumentComponent from './components/staff/DocumentComponent.vue'
import SickLeaveComponents from './components/staff/SickLeaveComponent.vue'

Vue.component('staff-sick-leave', SickLeaveComponents)
Vue.component('staff-leave-application', LeaveApplication)
Vue.component('staff-profile', StaffComponent)
Vue.component('staff-document', DocumentComponent)


