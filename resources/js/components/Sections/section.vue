<template>
    <div class="row">

        <div class="col-md-4">
            <card header="Section Form">
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
            <card header="Students">

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
            };
        },
        methods: {
            submitForm(){
                axios.post(route('sections.store'), this.formData);
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
        },
        mounted() {
            this.getSchoolYears();
            this.getGradeLevels();
            this.getTracks();
        }
    }
</script>
