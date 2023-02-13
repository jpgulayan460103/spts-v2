<template>
    <div>
        <div v-if="isEmpty(classRecordQuarter)" class="">
            <p v-if="user.account_type == 'admin'">
                Teacher: <br>
                <select v-model="subjectTeacherId">
                    <option value="">Select Teacher</option>
                    <option v-for="(teacher, index) in subjectTeachers" :key="index" :value="teacher.id">{{ teacher.full_name_last_name }}</option>
                </select> 
                <button class="btn btn-primary btn-sm" @click="updateSubjectTeacher">Save</button>
            </p>
            <hr v-if="user.account_type == 'admin'">
        </div>
        <div class="table-responsive" v-if="!isEmpty(classRecordQuarter)">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th v-for="(unit, uindex) in units" :key="uindex">
                            <a href="#" @click="viewUnit(unit)">{{ unit.name }}</a>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sectionStudent, index) in sectionStudents" :key="index">
                        <td>{{ sectionStudent.student.full_name_last_name }}</td>
                        <td v-for="(unit, uindex) in sectionStudent.units" :key="uindex">
                            <span>{{ unit.remarks }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive" v-else>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Student Name</th>
                        <th :colspan="attendances.length" style="text-align:center">
                            Week
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#attendanceModal" v-if="user.account_type == 'teacher' && user.userable_id == classRecord.teacher_id" v-tooltip="'Add Week'">
                                <b>+</b>
                            </button>
                        </th>
                        <th rowspan="2" style="text-align:center">Total Week Days</th>
                        <th rowspan="2" style="text-align:center">Total Present Days</th>
                    </tr>
                    <tr>
                        <th v-for="(attendance, attIndex) in attendances" :key="attIndex" style="text-align:center">
                            {{ attendance.week_name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sectionStudent, index) in sectionStudents" :key="index">
                        <td>{{ sectionStudent.student.full_name_last_name }}</td>
                        <td v-for="(attendance, attIndex) in attendances" :key="attIndex" style="text-align:center">
                            <input type="number" min="0" :max="attendance.total_days" :value="extractStudentAttendance(sectionStudent, attendance)" style="width: 50px;" @blur="addStudentAttendance($event, sectionStudent, attendance)" ref="attendance">
                        </td>
                        <td style="text-align:center">{{ totalWeekDays() }}</td>
                        <td style="text-align:center">{{ totalPresentDays(sectionStudent) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>




        <!-- Modal -->
        <div class="modal fade modal-sm" id="attendanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="addAttendance()">
                        <form-item label="Week Name or Number" :errors="formErrors.week_name">
                            <input type="text" v-model="formData.week_name" class="form-control" :class="formErrors.week_name ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="Number of Days" :errors="formErrors.total_days">
                            <input type="number" min="1" v-model="formData.total_days" class="form-control" :class="formErrors.total_days ? 'is-invalid' : ''">
                        </form-item>
                        <button type="submit" class="btn btn-primary" :disabled="submit">Add</button>
                    </form>
                    <ul class="list-group mt-2">
                        <li class="list-group-item d-flex justify-content-between align-items-center"><b>Week</b><b>Days</b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(attendance, attIndex) in attendances" :key="attIndex">
                            <span>{{ attendance.week_name }}</span>
                            <span>{{ attendance.total_days }}</span>
                            <button type="submit" class="btn btn-danger btn-sm" @click="deleteAttendance(attendance)">
                                <b>x</b>
                            </button>
                            <!-- <span>Delete</span> -->
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>

    import axios from 'axios';
    import { cloneDeep, isEmpty } from 'lodash'
    import FormItem from './../../FormItem.vue';

    export default {
        components: {
            FormItem
        },
        props: [
            'user',
            'classRecord',
            'classRecordQuarter',
            'section',
            'viewUnit'
        ],
        data() {
            return {
                sectionStudents: [],
                units: [],
                subjectTeachers: [],
                subjectTeacherId: "",
                formErrors: {},
                formData: {},
                attendances: [],
                submit: false,
            };
        },
        methods: {
            getUnitSummary(){
                axios.get(route('class-records.unit-summary', this.classRecord.id), {
                    params: {
                        class_record_quarter_id: this.classRecordQuarter.id
                    }
                })
                .then(res => {
                    this.sectionStudents = res.data.section_students;
                    this.units = res.data.units;
                })
                .catch(err => {});
            },
            getTeachers(){
                axios.get(route('all.teachers'))
                .then(res => {
                    this.subjectTeachers = res.data;
                })
                .catch(err => {});
            },
            updateSubjectTeacher(e){
                axios.put(route('class-records.update', this.classRecord.id), {
                    teacher_id: this.subjectTeacherId == "" ? null : this.subjectTeacherId,
                })
                .then(res => {
                    location.reload();
                })
                .catch(err => {});
            },
            isEmpty(value){
                return isEmpty(value);
            },
            getAttendances(){
                axios.get(route('attendances.index'), {
                    params: {
                        class_record_id: this.classRecord.id
                    }
                })
                .then(res => {
                    this.attendances = res.data;
                })
                .catch(err => {});
            },
            extractStudentAttendance(sectionStudent, attendance){
                let attendances = sectionStudent.attendances;
                let studentAttendance = attendances.filter(item => item.section_student_id == sectionStudent.id && item.attendance_id == attendance.id);
                if(!isEmpty(studentAttendance)){
                    return studentAttendance[0].present_days;
                }
                return 0;
            },
            addStudentAttendance(e, sectionStudent, attendance){
                let present_days = e.target.value;
                if(present_days > attendance.total_days){
                    this.$refs['attendance'][0].value = attendance.total_days;
                    present_days = attendance.total_days;
                }
                if(present_days < 1){
                    this.$refs['attendance'][0].value = 0;
                    present_days = 0;
                }

                let formData = {
                    attendance_id: attendance.id,
                    section_student_id: sectionStudent.id,
                    present_days: present_days,
                };
                axios.post(route('attendance-students.store'), formData)
                .then(res => {
                    this.getUnitSummary();
                    // this.getAttendances();
                })
                .catch(err => {});
            },
            addAttendance(){
                this.submit = true;
                axios.post(route('attendances.store'), {
                    ...this.formData,
                    class_record_id: this.classRecord.id
                })
                .then(res => {
                    this.submit = false;
                    this.formErrors = {};
                    this.formData = {};
                    this.getAttendances();
                })
                .catch(err => {
                    this.submit = false;
                    this.formErrors = err.response.data.errors;
                });
            },
            deleteAttendance(attendance){
                axios.delete(route('attendances.destroy', attendance.id))
                .then(res => {
                    this.getAttendances();
                })
                .catch(err => {

                });
            },
            totalWeekDays(){
                return this.attendances.reduce((sum, t) => {
                    return sum += t.total_days;
                }, 0);
            },
            totalPresentDays(sectionStudent){
                return sectionStudent.attendances.reduce((sum, t) => {
                    return sum += t.present_days;
                }, 0);
            },
        },
        mounted() {
            this.getUnitSummary();
            this.getTeachers();
            if(isEmpty(this.classRecordQuarter)){
                this.getAttendances();
            }
            this.subjectTeacherId = this.classRecord.teacher_id == null ? "" : this.classRecord.teacher_id;
        }
    }
</script>
