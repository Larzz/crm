//////////////////////////////////// IMPORTING ///////////////////////////////////////////////////

// widget
import Bulletin  from './components/general/BulletinComponent.vue'
import ClientWidget from './components/general/ClientWidgetComponent.vue'
import Popup from './components/general/PopupComponent.vue'
import EmployeeNotes from './components/general/EmployeeNotesComponent'
// pages
import Tutorial from './components/general/TutorialComponent.vue'
import Newsletter from './components/general/NewsletterComponent.vue'
import Website from './components/general/WebsiteComponent.vue'
import Presentation from './components/general/PresentationComponent.vue'
import Client from './components/general/ClientComponent.vue'
// popup
import CreateClientPopup from './components/general/popup/CreateClientComponent.vue'
import UploadDocumentPopup from './components/general/popup/UploadDocumentComponent.vue'
import CreateEmployeePopup from './components/general/popup/CreateEmployeeComponent.vue'
// form
import ClientForm from './components/general/form/ClientFormComponent.vue'
// table 
import ClientTable from './components/general/table/ClientTableComponent.vue'

import Vue from 'vue'

////////////////////////////////// DECLARATIONS //////////////////////////////////////////////////

// widget
Vue.component('general-bulletin-card', Bulletin)
Vue.component('general-client-card', ClientWidget)
Vue.component('popup', Popup)
Vue.component('general-employee-notes', EmployeeNotes)
// pages
Vue.component('tutorial', Tutorial)
Vue.component('newsletter', Newsletter)
Vue.component('website', Website)
Vue.component('presentation', Presentation)
Vue.component('client', Client)
// popup
Vue.component('create-client-popup', CreateClientPopup)
Vue.component('upload-document-popup', UploadDocumentPopup)
Vue.component('create-employee-popup', CreateEmployeePopup)
// form
Vue.component('client-form', ClientForm)
// table 
Vue.component('client-table', ClientTable)
