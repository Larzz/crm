import Bulletin  from './components/general/BulletinComponent.vue'
import Client from './components/general/ClientComponent.vue'
import Popup from './components/general/PopupComponent.vue'

import CreateClientPopup from './components/general/popup/CreateClientComponent.vue'
import UploadDocumentPopup from './components/general/popup/UploadDocumentComponent.vue'
import CreateEmployeePopup from './components/general/popup/CreateEmployeeComponent.vue'

Vue.component('general-bulletin-card', Bulletin)
Vue.component('general-client-card', Client)
Vue.component('popup', Popup)

Vue.component('create-client-popup', CreateClientPopup)
Vue.component('upload-document-popup', UploadDocumentPopup)
Vue.component('create-employee-popup', CreateEmployeePopup)
