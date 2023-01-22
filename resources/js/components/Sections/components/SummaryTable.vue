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
</template>

<script>

    import axios from 'axios';
    import { cloneDeep, isEmpty } from 'lodash'

    export default {
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
            }
        },
        mounted() {
            this.getUnitSummary();
            this.getTeachers();
            this.subjectTeacherId = this.classRecord.teacher_id == null ? "" : this.classRecord.teacher_id;
        }
    }
</script>
