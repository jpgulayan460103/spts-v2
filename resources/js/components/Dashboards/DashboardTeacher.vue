<template>
    <div class="row gy-2 gx-2">

        <div class="col-md-6">
            <card>
                <template v-slot:header>Assigned Subjects</template>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class Record ID</th>
                            <th>Semester</th>
                            <th>Subject Code</th>
                            <th>Subject Description</th>
                            <th style="text-align:center">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(classRecord, csindex) in classRecords" :key="csindex">
                            <td>{{ classRecord.id }}</td>
                            <td>{{ classRecord.subject.semester.name }}</td>
                            <td>{{ classRecord.subject.subject_code }}</td>
                            <td>{{ classRecord.subject.subject_description }}</td>
                            <td style="text-align:center">
                                <!-- <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" v-for="(quarter, qindex) in classRecord.quarters" :key="qindex">{{ quarter.quarter.name }}</button>
                                </div> -->
                                <button type="button" class="btn btn-primary" @click="viewClassRecord(classRecord)">
                                    <i class="bi bi-gear-fill"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </card>
        </div>

        <div class="col-md-6">
            <card>
                <template v-slot:header>Your Advisories</template>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Section Name</th>
                            <th>School Year</th>
                            <th>Grade Level</th>
                            <th>Track</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(section, index) in sections" :key="index">
                            <td>{{ section.section_name }}</td>
                            <td>{{ section.school_year.name }}</td>
                            <td>{{ section.grade_level.name }}</td>
                            <td>{{ section.track.name }}</td>
                            <td style="width: 120px;">
                                <button type="button" class="btn btn-primary" @click="manageClassRecord(section)">
                                    <i class="bi bi-book-fill"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="manageSection(section)">
                                    <i class="bi bi-people-fill"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </card>
        </div>

    </div>
</template>

<script>
    import Card from './../Card.vue';
    import FormItem from './../FormItem.vue';
    import axios from 'axios';
    import { cloneDeep, isEmpty, debounce } from 'lodash'

    export default {
        components: {
            Card,
            FormItem
        },
        props: [
            'user'
        ],
        data() {
            return {
                classRecords: [],
                sections: [],
            };
        },
        methods: {
            getClassRecords(){
                axios.get(route('teachers.class-records', this.user.userable_id))
                .then(res => {
                    this.classRecords = res.data.data;
                })
                .catch(res => {});
            },
            viewClassRecord(classRecord){
                window.location = route('sections.manage', {
                    uuid: classRecord.section.uuid,
                    type: 'class-records',
                    _query: {
                        cruid: classRecord.uuid,
                    }
                })
            },
            getAdvisories(){
                axios.get(route('teachers.advisories', this.user.userable_id))
                .then(res => {
                    this.sections = res.data.data;
                })
                .catch(res => {});
            },
            manageSection(section){
                window.location = route('sections.manage', [section.uuid, 'students']);
            },
            manageClassRecord(section){
                window.location = route('sections.manage', [section.uuid, 'class-records']);
            },
        },
        mounted() {
            this.getClassRecords();
            this.getAdvisories();
        }
    }
</script>
