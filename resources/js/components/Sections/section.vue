<template>
    <div class="row gy-2">

        <div class="col-md-4">
            <card>
                <template v-slot:header>Section Form</template>
                <form @submit.prevent="submitForm()">
                    <form-item label="Section Name">
                        <input type="text" v-model="formData.section_name" class="form-control">
                    </form-item>
                    <form-item label="School Year">
                        <select v-model="formData.school_year_id" class="form-control">
                            <option v-for="(item, index) in schoolYears" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <form-item label="Grade Level">
                        <select v-model="formData.grade_level_id" class="form-control">
                            <option v-for="(item, index) in gradeLevels" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <form-item label="Track">
                        <select v-model="formData.track_id" class="form-control">
                            <option v-for="(item, index) in tracks" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </card>
        </div>

        <div class="col-md-8">
            <card>
                <template v-slot:header>Sections</template>
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
                            <td>
                                <button type="button" class="btn btn-primary" @click="manageClassRecord(section)">
                                    <i class="bi bi-book-fill"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="manageStudent(section)">
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

    export default {
        components: {
            Card,
            FormItem
        },
        data() {
            return {
                formData: {},
                formErrors: {},
                schoolYears: [],
                gradeLevels: [],
                tracks: [],
                sections: [],
            };
        },
        methods: {
            submitForm(){
                axios.post(route('sections.store'), this.formData)
                .then(res => {
                    alert(`${this.formData.section_name} has been added`);
                    this.getSections();
                })
                .catch(res => {

                });
            },
            manageStudent(section){
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
            getSections(){
                axios.get(route('sections.index'))
                .then(res => {
                    this.sections = res.data;
                })
                .catch(err => {});
            }
        },
        mounted() {
            this.getSchoolYears();
            this.getGradeLevels();
            this.getTracks();
            this.getSections();
        }
    }
</script>
