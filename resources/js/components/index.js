import Vue from 'vue'

import Section from './Sections/Section'
import SelectedSection from './Sections/SelectedSection'
import Students from './Students/Students'
import Guardian from './Guardian/Guardian'
import Teachers from './Teachers/Teachers'
import DashboardTeacher from './Dashboards/DashboardTeacher'
import DashboardGuardian from './Dashboards/DashboardGuardian'
import DashboardStudent from './Dashboards/DashboardStudent'
import ChangePasswordModal from './ChangePasswordModal'

Vue.component('section-index', Section);
Vue.component('selected-section', SelectedSection);
Vue.component('student-index', Students);
Vue.component('guardian-index', Guardian);
Vue.component('teacher-index', Teachers);
Vue.component('dashboard-teacher', DashboardTeacher);
Vue.component('dashboard-guardian', DashboardGuardian);
Vue.component('dashboard-student', DashboardStudent);
Vue.component('change-password-modal', ChangePasswordModal);
// Vue.component('message', Message);
// Vue.component('failed-message', FailedMessage);
// Vue.component('sent-message', SentMessage);
// Vue.component('settings', Settings);