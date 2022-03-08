//////////////////////////////////// IMPORTING ///////////////////////////////////////////////////

// widget
import Bulletin  from './components/general/BulletinComponent.vue'
import Popup from './components/general/PopupComponent.vue'
import Notes from './components/general/NotesComponent'
import PresentationWidget from './components/general/widget/PresentationComponent.vue'
import MeetingWidget from './components/general/widget/MeetingComponent.vue'
import ClientWidget2 from './components/general/widget/ClientComponent.vue'
import DocumentWidget from './components/general/widget/DocumentComponent.vue'

// this was a mistake it should be under the table
import ClientWidget from './components/general/ClientWidgetComponent.vue'
// pages
import Tutorial from './components/general/TutorialComponent.vue'
import Newsletter from './components/general/NewsletterComponent.vue'
import Website from './components/general/WebsiteComponent.vue'
import Presentation from './components/general/PresentationComponent.vue'
import Client from './components/general/ClientComponent.vue'
import ClientDetails from './components/general/ClientDetails.vue'
import Tools from './components/general/ToolsComponent.vue'
// popup
import CreateClientPopup from './components/general/popup/CreateClientComponent.vue'
import UploadDocumentPopup from './components/general/popup/UploadDocumentComponent.vue'
import CreateEmployeePopup from './components/general/popup/CreateEmployeeComponent.vue'
import CreateNotePopup from './components/general/popup/CreateNoteComponent.vue'
import PresentationPopup from './components/general/popup/PresentationComponent.vue'
import MeetingMinutesPopup from './components/general/popup/MeetingMinutesComponent.vue'
import EditBulletinPopup from './components/general/popup/EditBulletinComponent.vue'
import EditClientPopup from './components/general/popup/EditClientComponent.vue'
import EditToolPopup from './components/general/popup/EditToolComponent.vue'
import BulettinPostPopup from './components/general/popup/BulettinPostComponent.vue'
// form
import ClientForm from './components/general/form/ClientFormComponent.vue'
import ToolForm from './components/general/form/ToolFormComponent.vue'
// table 
import ClientTable from './components/general/table/ClientTableComponent.vue'
import ToolTable from './components/general/table/ToolsTableComponent.vue'
import Vue from 'vue'

////////////////////////////////// DECLARATIONS //////////////////////////////////////////////////

// widget
Vue.component('presentation-widget', PresentationWidget)
Vue.component('meeting-widget', MeetingWidget)
Vue.component('client-widget', ClientWidget2)
Vue.component('document-widget', DocumentWidget)

Vue.component('general-bulletin-card', Bulletin)
Vue.component('general-client-card', ClientWidget)

Vue.component('popup', Popup)
Vue.component('notes', Notes) // widget
// pages
Vue.component('tutorial', Tutorial)
Vue.component('newsletter', Newsletter)
Vue.component('website', Website)
Vue.component('presentation', Presentation)
Vue.component('client', Client)
Vue.component('client-detail', ClientDetails)
Vue.component('tools', Tools)
// popup
Vue.component('create-client-popup', CreateClientPopup)
Vue.component('upload-document-popup', UploadDocumentPopup)
Vue.component('create-employee-popup', CreateEmployeePopup)
Vue.component('create-note-popup', CreateNotePopup)
// new naming method, need to change the above when have time
Vue.component('presentation-popup', PresentationPopup)
Vue.component('meeting-minutes-popup', MeetingMinutesPopup)
Vue.component('edit-bulletin-popup', EditBulletinPopup)
Vue.component('edit-client-popup', EditClientPopup)
Vue.component('edit-tool-popup', EditToolPopup)
Vue.component('bulletin-post-popup', BulettinPostPopup)
// form
Vue.component('client-form', ClientForm)
Vue.component('tool-form', ToolForm)
// table 
Vue.component('client-table', ClientTable)
Vue.component('tool-table', ToolTable)