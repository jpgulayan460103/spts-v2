<template>
    <div class="row gy-2">
        <div class="col-md-4">
            <card>
                <template v-slot:header>Section Form</template>
                <form @submit.prevent="submitForm()">
                    <form-item label="Grade Level" v-if="formType == 'create'" :errors="formErrors.grade_level_id">
                        <select v-model="formData.grade_level_id" class="form-control" placeholder="Select grade level" :class="formErrors.grade_level_id ? 'is-invalid' : ''">
                            <option v-for="(item, index) in gradeLevels" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <form-item label="Section Name" :errors="formErrors.section_name">
                        <input type="text" v-model="formData.section_name" class="form-control" :class="formErrors.section_name ? 'is-invalid' : ''">
                    </form-item>
                    <form-item label="School Year" v-if="formType == 'create'" :errors="formErrors.school_year_id">
                        <select v-model="formData.school_year_id" class="form-control" placeholder="Select school year" :class="formErrors.school_year_id ? 'is-invalid' : ''">
                            <option v-for="(item, index) in schoolYears" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <form-item label="Track" v-if="formType == 'create'" :errors="formErrors.track_id">
                        <select v-model="formData.track_id" class="form-control"  placeholder="Select track" :class="formErrors.track_id ? 'is-invalid' : ''">
                            <option v-for="(item, index) in tracks" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <form-item label="Adviser" :errors="formErrors.adviser_id">
                        <select v-model="formData.adviser_id" class="form-control" placeholder="Select teacher" :class="formErrors.adviser_id ? 'is-invalid' : ''">
                            <option v-for="(item, index) in advisers" :key="index" :value="item.id">{{ item.full_name_last_name }}</option>
                        </select>
                    </form-item>
                    <button type="submit" class="btn btn-primary" :disabled="submit">
                        <span v-if="formType == 'create'">Create Section</span>
                        <span v-else>Update Section</span>
                    </button>
                    <button type="button" style="display:none">Button</button>
                    <button type="button" class="btn btn-danger" v-if="formType != 'create'" @click="resetForm">Cancel</button>
                </form>
            </card>
        </div>

        <div class="col-md-8">
            <card>
                <template v-slot:header>Sections</template>
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
                            <td style="width: 200px">
                                <button type="button" class="btn btn-primary" @click="manageClassRecord(section)"  v-tooltip="'View Class Record'">
                                    <i class="bi bi-book-fill"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="manageSection(section)"  v-tooltip="'View Students'">
                                    <i class="bi bi-people-fill"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="editSection(section)" v-tooltip="'Edit Class Record'">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger" @click="deleteSection(section)" v-tooltip="'Delete Section'">
                                    <i class="bi bi-trash"></i>
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
        data() {
            return {
                submit: false,
                formData: {},
                formType: "create",
                formErrors: {},
                schoolYears: [],
                gradeLevels: [],
                tracks: [],
                sections: [],
                sectionPaginations: [],
                sectionFilterData: {
                    page: 1,
                    searchQuery: "",
                },
                advisers: [],
            };
        },
        methods: {
            submitForm: debounce(function(){
                this.submit = true;
                if(this.formType == "update"){
                    axios.put(route('sections.update', this.formData.id), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getSections();
                        this.resetForm();
                        alert(`Section has been updated.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors;
                    });
                }else{
                    axios.post(route('sections.store'), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getSections();
                        this.resetForm();
                        alert(`Section has been added.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors;
                    });
                }
            }, 250),
            manageSection(section){
                window.location = route('sections.manage', [section.uuid, 'students']);
            },
            manageClassRecord(section){
                window.location = route('sections.manage', [section.uuid, 'class-records']);
            },
            getSchoolYears(){
                axios.get(route('libraries.type', 'school_years'))
                .then(res => {
                    this.schoolYears = res.data;
                })
                .catch(err => {});
            },
            getGradeLevels(){
                axios.get(route('libraries.type', 'grade_levels'))
                .then(res => {
                    this.gradeLevels = res.data;
                })
                .catch(err => {});
            },
            getTracks(){
                axios.get(route('libraries.type', 'tracks'))
                .then(res => {
                    this.tracks = res.data;
                })
                .catch(err => {});
            },
            getSections: debounce(function(){
                axios.get(route('sections.index'), {
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
            editSection(section){
                this.formData = cloneDeep(section);
                this.formType = "update";
            },
            deleteSection(section){
                if(confirm("Are you sure you want to delete?")){
                    axios.delete(route('sections.destroy', section.id))
                    .then(res => {
                        this.getSections();
                    })
                    .catch(err => {});
                }
            },
            resetForm(){
                this.formData = {};
                this.formErrors = {};
                this.formType = "create";
            },
            getAdvisers(){
                axios.get(route('all.teachers'))
                .then(res => {
                    this.advisers = res.data;
                })
                .catch(err => {});
            }
        },
        mounted() {
            this.getSchoolYears();
            this.getGradeLevels();
            this.getTracks();
            this.getSections();
            this.getAdvisers();
        }
    }
</script>
