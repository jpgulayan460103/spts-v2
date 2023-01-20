<template>
    <div>
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
                    <td>
                        <span>{{ sectionStudent.student.last_name }}</span>,
                        <span>{{ sectionStudent.student.first_name }}</span>
                        <span>{{ sectionStudent.student.middle_name }}</span>
                        <span>{{ sectionStudent.student.ext_name }}</span>
                    </td>
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
            'classRecord',
            'classRecordQuarter',
            'section',
            'viewUnit'
        ],
        data() {
            return {
                sectionStudents: [],
                units: [],
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
            }
        },
        mounted() {
            this.getUnitSummary();
        }
    }
</script>
