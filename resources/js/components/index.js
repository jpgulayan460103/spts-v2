import Vue from 'vue'

import Section from './Sections/Section'
import SelectedSection from './Sections/SelectedSection'
import Students from './Students/Students'
import Teachers from './Teachers/Teachers'

Vue.component('section-index', Section);
Vue.component('selected-section', SelectedSection);
Vue.component('student-index', Students);
Vue.component('teacher-index', Teachers);
// Vue.component('message', Message);
// Vue.component('failed-message', FailedMessage);
// Vue.component('sent-message', SentMessage);
// Vue.component('settings', Settings);