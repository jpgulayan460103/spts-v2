<template>
    <div class="row gy-2 gx-2">

        <div class="col-md-6">
            <card style="min-height: 90vh">
                <template v-slot:header>Assigned Subjects</template>
                <form @submit.prevent="getClassRecords()">
                    <div class="row gx-0">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="classRecordFilterData.searchQuery" placeholder="Search for subject or section name" aria-label="Search for subject or section name" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Class Record ID</th>
                                <th>Semester</th>
                                <th>Subject Description</th>
                                <th>Grade</th>
                                <th>Section Name</th>
                                <th>School Year</th>
                                <th style="text-align:center">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(classRecord, csindex) in classRecords" :key="csindex">
                                <td>{{ classRecord.id }}</td>
                                <td>{{ classRecord.subject.semester.name }}</td>
                                <td>{{ classRecord.subject.subject_description }}</td>
                                <td>{{ classRecord.section.grade_level.name }}</td>
                                <td>{{ classRecord.section.section_name }}</td>
                                <td>{{ classRecord.section.school_year.name }}</td>
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
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" :class="{ active: pagination.active }" v-for="(pagination, index) in classRecordPaginations" :key="index" @click="navigateClassRecordPages(pagination.label)">
                            <a class="page-link" href="javascript:void(0);" v-if="pagination.url != null">
                                <span v-html="pagination.label"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </card>
        </div>

        <div class="col-md-6">
            <card style="min-height: 90vh">
                <template v-slot:header>Your Advisories</template>
                <form @submit.prevent="getSections()">
                    <div class="row gx-0">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="sectionFilterData.searchQuery" placeholder="Search for section name" aria-label="Search for section name" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
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
                </div>
                
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" :class="{ active: pagination.active }" v-for="(pagination, index) in sectionPaginations" :key="index" @click="navigateSectionPages(pagination.label)">
                            <a class="page-link" href="javascript:void(0);" v-if="pagination.url != null">
                                <span v-html="pagination.label"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
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
                classRecordPaginations: [],
                classRecordFilterData: {
                    page: 1,
                    searchQuery: "",
                },
                sections: [],
                sectionPaginations: [],
                sectionFilterData: {
                    page: 1,
                    searchQuery: "",
                },
            };
        },
        methods: {
            getClassRecords: debounce(function(){
                axios.get(route('teachers.class-records', this.user.userable_id), {
                    params: this.classRecordFilterData
                })
                .then(res => {
                    this.classRecords = res.data.data;
                    this.classRecordPaginations = res.data.links;
                })
                .catch(res => {});
            }, 250),
            navigateClassRecordPages(label){
                if(label == "Next &raquo;"){
                    label = this.classRecordFilterData.page + 1;
                }else if(label == "&laquo; Previous"){
                    label = this.classRecordFilterData.page - 1;
                }
                this.classRecordFilterData.page = label;
                this.getClassRecords();
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
            getSections: debounce(function(){
                axios.get(route('teachers.advisories', this.user.userable_id), {
                    params: this.sectionFilterData
                })
                .then(res => {
                    this.sections = res.data.data;
                    this.sectionPaginations = res.data.links;
                })
                .catch(res => {});
            }, 250),
            navigateSectionPages(label){
                if(label == "Next &raquo;"){
                    label = this.sectionFilterData.page + 1;
                }else if(label == "&laquo; Previous"){
                    label = this.sectionFilterData.page - 1;
                }
                this.sectionFilterData.page = label;
                this.getSections();
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
            this.getSections();
        }
    }
</script>
