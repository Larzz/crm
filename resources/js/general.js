import Bulletin  from './components/general/BulletinComponent.vue'
import Client from './components/general/ClientComponent.vue'
import Popup from './components/general/PopupComponent.vue'

import EmployeeNotes from './components/general/EmployeeNotesComponent'

import Tutorial from './components/general/TutorialComponent.vue'
import Newsletter from './components/general/NewsletterComponent.vue'
import Website from './components/general/WebsiteComponent.vue'

import CreateClientPopup from './components/general/popup/CreateClientComponent.vue'
import UploadDocumentPopup from './components/general/popup/UploadDocumentComponent.vue'
import CreateEmployeePopup from './components/general/popup/CreateEmployeeComponent.vue'
import Vue from 'vue'

Vue.component('general-bulletin-card', Bulletin)
Vue.component('general-client-card', Client)
Vue.component('popup', Popup)

Vue.component('general-employee-notes', EmployeeNotes)

Vue.component('tutorial', Tutorial)
Vue.component('newsletter', Newsletter)
Vue.component('website', Website)

Vue.component('create-client-popup', CreateClientPopup)
Vue.component('upload-document-popup', UploadDocumentPopup)
Vue.component('create-employee-popup', CreateEmployeePopup)
