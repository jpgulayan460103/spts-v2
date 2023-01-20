import Vue from 'vue'

import Section from './Sections/Section'
import SelectedSection from './Sections/SelectedSection'
import Students from './Students/Students'

Vue.component('section-index', Section);
Vue.component('selected-section', SelectedSection);
Vue.component('student-index', Students);
// Vue.component('message', Message);
// Vue.component('failed-message', FailedMessage);
// Vue.component('sent-message', SentMessage);
// Vue.component('settings', Settings);