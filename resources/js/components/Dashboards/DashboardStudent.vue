<template>
    <div class="row gy-2 gx-2">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" v-if="user.account_type == 'guardian' && !isEmpty(section)">
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="/">My Students</a></li> -->
                    <li class="breadcrumb-item" aria-current="page" :class="isEmpty(section) ? 'active' : ''" v-if="!isEmpty(section)">
                        <span v-if="isEmpty(section)">{{ student.full_name_first_name }}</span>
                        <a :href="backToEnrolledUrl()" v-else>{{ student.full_name_first_name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page" v-if="!isEmpty(section)">
                        {{ section.grade_level.name }} - {{ section.section_name }} - {{ section.school_year.name }} - {{ section.track.name }}
                    </li>
                </ol>
            </nav>
            <!-- <nav aria-label="breadcrumb" v-else>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page" v-if="!isEmpty(section)">
                        <a v-if="isEmpty(section)" :href="backToEnrolledUrl()">{{ student.full_name_first_name }}</a>
                        <a :href="backToEnrolledUrl()" v-else>{{ student.full_name_first_name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page" v-if="!isEmpty(section)">
                        {{ section.grade_level.name }} - {{ section.section_name }} - {{ section.school_year.name }} - {{ section.track.name }}
                    </li>
                </ol>
            </nav> -->

        </div>
        <div class="col-md-2">
            <card style="min-height: 90vh">
                <template v-slot:header>Student Information</template>
                <div @click="changePhoto" style="cursor: pointer;" title="Click to change Photo">
                    <img :src="studentPhoto != '/storage/' ? studentPhoto : userImage" style="width: 2in; height: 2in;border-radius: 50%;"  class="mx-auto d-block img-thumbnail" />
                </div>

                <form-item label=" " :errors="formErrors.photo">
                    <input class="form-control" type="file" id="formFile" ref="photo" @change="uploadPhoto" style="display:none" accept=".jpeg,.jpg,.png">
                </form-item>
                <form-item label="Student ID Number">
                    <input type="text" v-model="student.student_id_number" class="form-control" readonly>
                </form-item>
                <form-item label="Last Name">
                    <input type="text" v-model="student.last_name" class="form-control" readonly>
                </form-item>
                <form-item label="First Name">
                    <input type="text" v-model="student.first_name" class="form-control" readonly>
                </form-item>
                <form-item label="Middle Name">
                    <input type="text" v-model="student.middle_name" class="form-control" readonly>
                </form-item>
                <form-item label="Ext Name">
                    <input type="text" v-model="student.ext_name" class="form-control" readonly>
                </form-item>
                <form-item label="Gender">
                    <input type="text" v-model="student.gender.name" class="form-control" readonly>
                </form-item>
            </card>
        </div>
        <!-- No Section Selected -->
        <div class="col-md-10" v-if="isEmpty(section)">
            <card style="min-height: 90vh">
                <template v-slot:header>Enrolled Classes</template>

                <form @submit.prevent="getSections()" id="section-table">
                        <div class="row gx-0">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" v-model="sectionFilterData.searchQuery" placeholder="Search for section name" aria-label="Search for section name" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit" form="section-table" id="button-addon2">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Grade Level</th>
                            <th>Section Name</th>
                            <th>School Year</th>
                            <th>Track</th>
                            <th>Adviser</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(section, index) in sections" :key="index">
                            <td>{{ section.grade_level.name }}</td>
                            <td>{{ section.section_name }}</td>
                            <td>{{ section.school_year.name }}</td>
                            <td>{{ section.track.name }}</td>
                            <td>{{ section.adviser ? section.adviser.full_name_last_name : "" }}</td>
                            <td>
                                <a type="button" class="btn btn-primary" :href="sectionUrl(section)">
                                    <i class="bi bi-book-fill"></i>
                                </a>
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

         <!-- Section Selected -->
        <div class="col-md-10" v-else>
            <card style="min-height: 90vh">
                <template v-slot:header>{{ section.grade_level.name }} - {{ section.section_name }} - {{ section.school_year.name }} - {{ section.track.name }}</template>

                <div class="accordion" id="accordionFlushExample">
                    
                    <div class="accordion-item" v-for="(subject, index) in subjects" :key="index">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="`#flush-collapseOne-${subject.subject_id}`" aria-expanded="false" :aria-controls="`flush-collapseOne-${subject.subject_id}`" @click="loadSubjectSummary(subject)">
                            {{ subject.subject.semester.name }} - {{ subject.subject.subject_description }}
                        </button>
                        </h2>
                        <div :id="`flush-collapseOne-${subject.subject_id}`" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <h5>Attendance</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borders">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Week</th>
                                                    <th style="text-align: center">Days</th>
                                                    <th style="text-align: center">Present</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(attendance, attIndex) in attendances" :key="attIndex">
                                                    <td style="text-align: center">{{ attendance.attendance.week_name }}</td>
                                                    <td style="text-align: center">{{ attendance.attendance.total_days }}</td>
                                                    <td style="text-align: center">{{ attendance.present_days }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>TOTAL:</th>
                                                    <th style="text-align: center">{{ week_days }}</th>
                                                    <th style="text-align: center">{{ present_days }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div style="height: 300px">
                                        <line-chart :data="chartOneData" :options="chartOptions" />
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Unit Name</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                                <th>Descriptor</th>
                                                <th>Teacher Action</th>
                                                <th>Teacher Feedback</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(tOneData, tOneIndex) in tableOneData" :key="tOneIndex">
                                                <td>{{ tOneData.unit_name }}</td>
                                                <td>{{ tOneData.transmuted_grade }}</td>
                                                <td>{{ tOneData.remarks }}</td>
                                                <td>{{ tOneData.descriptor }}</td>
                                                <td>{{ !isEmpty(tOneData.unit_action) ? tOneData.unit_action.action.name : ""}}</td>
                                                <td>{{ !isEmpty(tOneData.unit_action) ? tOneData.unit_action.teacher_feedback : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div style="height: 300px">
                                        <line-chart :data="chartTwoData" :options="chartOptions" />
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Unit Name</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                                <th>Descriptor</th>
                                                <th>Teacher Action</th>
                                                <th>Teacher Feedback</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(tTwoData, tTwoIndex) in tableTwoData" :key="tTwoIndex">
                                                <td>{{ tTwoData.unit_name }}</td>
                                                <td>{{ tTwoData.transmuted_grade }}</td>
                                                <td>{{ tTwoData.remarks }}</td>
                                                <td>{{ tTwoData.descriptor }}</td>
                                                <td>{{ !isEmpty(tTwoData.unit_action) ? tTwoData.unit_action.action.name : ""}}</td>
                                                <td>{{ !isEmpty(tTwoData.unit_action) ? tTwoData.unit_action.teacher_feedback : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>



            </card>
        </div>
        

    </div>
</template>

<script>
    import Card from './../Card.vue';
    import FormItem from './../FormItem.vue';
    import axios from 'axios';
    import { cloneDeep, isEmpty, debounce, map } from 'lodash'
    import userImage from "./../../images/user.png"

    import {
        Chart as ChartJS,
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        Title,
        Tooltip,
        Legend
    } from 'chart.js'

    import { Line } from 'vue-chartjs'

    ChartJS.register(
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        Title,
        Tooltip,
        Legend
    )

    export default {
        components: {
            Card,
            FormItem,
            'line-chart': Line,
        },
        props: [
            'user',
            'student',
            'section',
        ],
        data() {
            return {
                userImage,
                studentPhoto: null,
                subjects: [],
                sections: [],
                sectionPaginations: [],
                sectionFilterData: {
                    page: 1,
                    searchQuery: "",
                },
                selectedPhoto: null,
                formErrors: {},
                attendances: [],
                present_days: 0,
                week_days: 0,
                chartOneData: {
                    labels: [],
                    datasets: [],
                },
                chartTwoData: {
                    labels: [],
                    datasets: [],
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Units'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Transmuted Grades'
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    }
                },
                tableOneData: [],
                tableTwoData: [],
            };
        },
        methods: {
            getSections: debounce(function(){
                axios.get(route('students.sections', this.student.id), {
                    params: this.sectionFilterData
                })
                .then(res => {
                    this.sections = res.data.data;
                    this.sectionPaginations = res.data.links;
                })
                .catch(err => {});
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
            viewSection(section){
                window.location = route('home', {
                    _query: {
                        sctuid: section.uuid,
                    }
                })
            },
            changePhoto(){
                this.$refs.photo.click();
            },
            uploadPhoto(){
                this.selectedPhoto = this.$refs.photo.files[0];
                let formData = new FormData();

                formData.append("photo", this.selectedPhoto);

                axios.post(route('students.photo', this.student.id), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    this.studentPhoto = cloneDeep(res.data.photo);
                })
                .catch(err => {
                    this.formErrors = err.response.data.errors;
                })
                ;
            },
            getSectionSubjects(){
                axios.get(route('sections.subjects', this.section.id))
                .then(res => {
                    this.subjects = res.data.subjects;
                })
                .catch(err => {})
                ;
            },
            sectionUrl(section){
                if(this.user.account_type == "guardian"){
                    return `/?stduid=${this.student.uuid}&sctuid=${section.uuid}`;
                }
                return `/?sctuid=${section.uuid}`;
                
            },
            backToEnrolledUrl(){
                if(this.user.account_type == "guardian"){
                    return `/?stduid=${this.student.uuid}`;
                }
                return `/`;
                
            },
            loadSubjectSummary(subject){
                axios.get(route('students.subject.summary', this.student.id), {
                    params: {
                        subject_id: subject.subject_id,
                        section_id: this.section.id
                    }
                })
                .then(res => {
                    let result = res.data;
                    this.attendances = res.data.attendances;
                    this.present_days = res.data.present_days;
                    this.week_days = res.data.week_days;
                    let quarterOne = result.quarters[0];
                    let quarterOneUnits = quarterOne.units
                    let quarterOneLabels = map(quarterOneUnits, "name");
                    let quarterOneSummary = map(quarterOneUnits, "summary");
                    let quarterOneTransmutedGrades = map(quarterOneSummary, 'transmuted_grade');
                    let quarterOneDescriptor = map(quarterOneSummary, 'descriptor');
                    let quarterOneRemarks = map(quarterOneSummary, 'remarks');
                    let quarterOneUnitAction = map(quarterOneSummary, 'unit_action');
                    this.chartOneData = {
                        labels: quarterOneLabels,
                        datasets: [
                            {
                                label: quarterOne.quarter.name,
                                borderColor: '#e74c3c',
                                backgroundColor: '#e74c3c',
                                data: quarterOneTransmutedGrades
                            }
                        ],
                    }

                    this.tableOneData = [];

                    for (let index = 0; index < quarterOneUnits.length; index++) {
                        this.tableOneData[index] = {
                            unit_name: quarterOneUnits[index].name,
                            transmuted_grade: quarterOneTransmutedGrades[index],
                            descriptor: quarterOneDescriptor[index],
                            remarks: quarterOneRemarks[index],
                            unit_action: quarterOneUnitAction[index],
                        }        
                    }

                    let quarterTwo = result.quarters[1];
                    let quarterTwoUnits = quarterTwo.units
                    let quarterTwoLabels = map(quarterTwoUnits, "name");
                    let quarterTwoSummary = map(quarterTwoUnits, "summary");
                    let quarterTwoTransmutedGrades = map(quarterTwoSummary, 'transmuted_grade');
                    let quarterTwoDescriptor = map(quarterTwoSummary, 'descriptor');
                    let quarterTwoRemarks = map(quarterTwoSummary, 'remarks');
                    let quarterTwoUnitAction = map(quarterTwoSummary, 'unit_action');
                    this.chartTwoData = {
                        labels: quarterTwoLabels,
                        datasets: [
                            {
                                label: quarterTwo.quarter.name,
                                borderColor: '#27ae60',
                                backgroundColor: '#27ae60',
                                data: quarterTwoTransmutedGrades
                            }
                        ],
                    }

                    this.tableTwoData = [];

                    for (let index = 0; index < quarterTwoUnits.length; index++) {
                        this.tableTwoData[index] = {
                            unit_name: quarterTwoUnits[index].name,
                            transmuted_grade: quarterTwoTransmutedGrades[index],
                            descriptor: quarterTwoDescriptor[index],
                            remarks: quarterTwoRemarks[index],
                            unit_action: quarterTwoUnitAction[index],
                        }        
                    }

                    
                    // console.log(transmuted_grades);
                    // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    // datasets: [
                    //     {
                    //         label: 'Data One',
                    //         backgroundColor: '#f87979',
                    //         data: [40, 39, 10, 40, 39, 80, 40]
                    //     }
                    // ],
                })
                .catch(err => {});
            },
            isEmpty(value){
                return isEmpty(value);
            }
        },
        mounted() {
            this.studentPhoto = cloneDeep(this.student.photo);
            if(!isEmpty(this.section)){
                this.getSectionSubjects();
            }else{
                this.getSections();
            }
        }
    }
</script>
